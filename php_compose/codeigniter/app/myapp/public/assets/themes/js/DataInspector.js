//"use strict";
/*
*  Copyright (C) 1998-2017 by Northwoods Software Corporation. All Rights Reserved.
*/

/**
  Esta clase implementa un inspector para los objetos de datos del modelo GoJS.
  El constructor toma tres argumentos:
    {String} divide una cadena que hace referencia al ID HTML de la div del inspector a ser.
    Diagrama {Diagrama} una referencia a un Diagrama de GoJS.
    Opciones {Object} Objeto JS opcional que describe opciones para el inspector.

  Opciones:
    InspectSelection {boolean} Por defecto true, si se mostrará automáticamente y se llenará el Inspector
                               Con la parte de diagrama actualmente seleccionada. Si se establece en false, el inspector no mostrará nada
                               Hasta que llame a Inspector.inspectObject (object) con un objeto Part o JavaScript como argumento.
    IncludesOwnProperties {boolean} Valor por defecto true, si desea listar todas las propiedades actualmente en el objeto de datos inspeccionado.
    Properties {Object} Un objeto de string: Pares de objetos que representan propertyName: propertyOptions.
                        Se puede utilizar para incluir o excluir propiedades adicionales.
    PropertyModified función (propertyName, newValue) una devolución de llamada

  Opciones para propiedades:
    Show: {boolean | function} un valor booleano para mostrar u ocultar la propiedad del inspector,
           o una función de predicado para mostrar condicionalmente.
    ReadOnly: {boolean | function} si la propiedad es de solo lectura
    Type: {string} una cadena que describe el tipo de datos. Valores soportados: "string | number | color | boolean" 
           No implementado aún: "point | rect | size"
    DefaultValue: {*} un valor predeterminado para la propiedad. De forma predeterminada a la cadena vacía.

  Ejemplo de uso de Inspector:

  var inspector = new Inspector("myInspector", myDiagram,
    {
      includesOwnProperties: false,
      properties: {
        "key": { readOnly: true, show: Inspector.showIfPresent },
        "comments": { show: Inspector.showIfNode  },
        "LinkComments": { show: Inspector.showIfLink },
      }
    });

  This is the basic HTML Structure that the Inspector creates within the given DIV element:

  <div id="divid" class="inspector">
    <tr>
      <td>propertyName</td>
      <td><input value=propertyValue /></td>
    </tr>
    ...
  </div>

*/
function Inspector(divid, diagram, options) {
  var mainDiv = document.getElementById(divid);
  mainDiv.className = "inspector";
  mainDiv.innerHTML = "";
  this._div = mainDiv;
  this._diagram = diagram;
  this._inspectedProperties = {};

  // Ya sea una Parte GoJS o un objeto de datos simple, como Model.modelData
  this.inspectedObject = null;

  // Opciones predeterminadas de Inspector:
  this.includesOwnProperties = true;
  this.declaredProperties = {};
  this.inspectsSelection = true;
  this.propertyModified = null;

  if (options !== undefined) {
    if (options["includesOwnProperties"] !== undefined) this.includesOwnProperties = options["includesOwnProperties"];
    if (options["properties"] !== undefined) this.declaredProperties = options["properties"];
    if (options["inspectSelection"] !== undefined) this.inspectsSelection = options["inspectSelection"];
    if (options["propertyModified"] !== undefined) this.propertyModified = options["propertyModified"];
  }

  var self = this;
  diagram.addModelChangedListener(function(e) {
    if (e.isTransactionFinished) self.inspectObject();
  });
  if (this.inspectsSelection) {
    diagram.addDiagramListener("ChangedSelection", function(e) { self.inspectObject(); });
  }
}

// Algunos predicados estáticos para usar con la propiedad "show".
Inspector.showIfNode = function(part) { return part instanceof go.Node };
Inspector.showIfLink = function(part) { return part instanceof go.Link };
Inspector.showIfGroup = function(part) { return part instanceof go.Group };

// Mostrar sólo la propiedad si su presente. Útil para "clave" que se mostrará en Nodos y Grupos, pero normalmente no en Enlaces
Inspector.showIfPresent = function(data, propname) {
  if (data instanceof go.Part) data = data.data;
  return typeof data === "object" && data[propname] !== undefined;
};

/**
* Actualice el estado HTML de este Inspector teniendo en cuenta las propiedades del {@link #inspectedObject}.
* @param {Object} Object es un argumento opcional, usado cuando {@link #inspectSelection} es falso para
*                Establecer {@link #inspectedObject} y mostrar y editar las propiedades de ese objeto
*/
Inspector.prototype.inspectObject = function(object) {
  var inspectedObject = object;
  if (inspectedObject === undefined) {
    if (this.inspectsSelection)
      inspectedObject = this._diagram.selection.first();
    else
      inspectedObject = this.inspectedObject;
  }

  if (inspectedObject === null || this.inspectedObject === inspectedObject) {
    this.inspectedObject = inspectedObject;
    this.updateAllHTML();
    return;
  }

  this.inspectedObject = inspectedObject;
  var mainDiv = this._div;
  mainDiv.innerHTML = "";
  if (inspectedObject === null) return;

  // Utilice el Part.data o el propio objeto (para model.modelData)
  var data = (inspectedObject instanceof go.Part) ? inspectedObject.data : inspectedObject;
  if (!data) return;
  // Contruir tabla
  var table = document.createElement("table");
  var tbody = document.createElement("tbody");
  this._inspectedProperties = {};
  this.tabIndex = 0;
  var declaredProperties = this.declaredProperties;

  // Revise todas las propiedades pasadas al inspector y muéstrelas, si procede:
  for (var k in declaredProperties) {
    var val = declaredProperties[k];
    if (!this.canShowProperty(k, val, inspectedObject)) continue;
    var defaultValue = "";
    if (val.defaultValue !== undefined) defaultValue = val.defaultValue;
    if (data[k] !== undefined) defaultValue = data[k];
    tbody.appendChild(this.buildPropertyRow(k, defaultValue || ""));
  }
  // Revise todas las propiedades de los datos del modelo y muéstrelas, si procede
  if (this.includesOwnProperties) {
    for (var k in data) {
      if (k === "__gohashid") continue; // Saltar la propiedad de hash GoJS interna
      if (this._inspectedProperties[k]) continue; // ya existe
      if (declaredProperties[k] && !this.canShowProperty(k, declaredProperties[k], inspectedObject)) continue;
      tbody.appendChild(this.buildPropertyRow(k, data[k]));
    }
  }

  table.appendChild(tbody);
  mainDiv.appendChild(table);
};

/**
* @ignore
* This predicate should be false if the given property should not be shown.
* Normally it only checks the value of "show" on the property descriptor.
* The default value is true.
* @param {string} propertyName the property name
* @param {Object} propertyDesc the property descriptor
* @param {Object} inspectedObject the data object
* @return {boolean} whether a particular property should be shown in this Inspector
*/
Inspector.prototype.canShowProperty = function(propertyName, propertyDesc, inspectedObject) {
  if (propertyDesc.show === false) return false;
  // Si "show" es un predicado, asegúrese de que pasa o no muestre esta propiedad
  if (typeof propertyDesc.show === "function") return propertyDesc.show(inspectedObject, propertyName);
  return true;
}

/**
* @ignore
* This predicate should be false if the given property should not be editable by the user.
* Normally it only checks the value of "readOnly" on the property descriptor.
* The default value is true.
* @param {string} propertyName the property name
* @param {Object} propertyDesc the property descriptor
* @param {Object} inspectedObject the data object
* @return {boolean} whether a particular property should be shown in this Inspector
*/
Inspector.prototype.canEditProperty = function(propertyName, propertyDesc, inspectedObject) {
  // Supongamos que los valores de propiedad que son funciones de objetos no se pueden editar
  var data = (inspectedObject instanceof go.Part) ? inspectedObject.data : inspectedObject;
  var valtype = typeof data[propertyName];
  if (valtype === "function" || valtype === "object") return false;  //?? handle Objects such as Points
  if (propertyDesc) {
    if (propertyDesc.readOnly === true) return false;
    // Si "readOnly" es un predicado, asegúrese de que pasa o no mostrar esta propiedad
    if (typeof propertyDesc.readOnly === "function") return !propertyDesc.readOnly(inspectedObject, propertyName);
  }
  return true;
}

/**
* @ignore
* This sets this._inspectedProperties[propertyName] and creates the HTML table row:
*    <tr>
*      <td>propertyName</td>
*      <td><input value=propertyValue /></td>
*    </tr>
* @param {string} propertyName the property name
* @param {*} propertyValue the property value
* @return the table row
*/
Inspector.prototype.buildPropertyRow = function(propertyName, propertyValue) {
  var mainDiv = this._div;
  var tr = document.createElement("tr");

  var td1 = document.createElement("td");
  td1.textContent = propertyName;
  tr.appendChild(td1);

  var td2 = document.createElement("td");
  var input = document.createElement("input");
  var decProp = this.declaredProperties[propertyName];
  input.tabIndex = this.tabIndex++;

  var self = this;
  function setprops() { self.updateAllProperties(); }

  input.value = propertyValue;
  input.disabled = !this.canEditProperty(propertyName, decProp, this.inspectedObject);
  if (decProp !== undefined && decProp.type === "color") {
    input.setAttribute("type", "color");
    if (input.type === "color") {
      input.addEventListener("input", setprops);
      input.addEventListener("change", setprops);
      input.value = this.setColor(propertyValue);
    }
  }
  if (this._diagram.model.isReadOnly) input.disabled = true;

  if (input.type !== "color") input.addEventListener("blur", setprops);

  td2.appendChild(input);
  tr.appendChild(td2);

  this._inspectedProperties[propertyName] = input;
  return tr;
};

/**
* @ignore
* HTML5 color input will only take hex,
* so let HTML5 canvas convert the color into hex format.
* This converts "rgb(255, 0, 0)" into "#FF0000", etc.
* @param {string} propertyValue
* @return {string}
*/
Inspector.prototype.setColor = function(propertyValue) {
  var ctx = document.createElement("canvas").getContext("2d");
  ctx.fillStyle = propertyValue;
  return ctx.fillStyle;
}

/**
* @ignore
* Actualizar todo el HTML en este Inspector.
*/
Inspector.prototype.updateAllHTML = function() {
  var inspectedProps = this._inspectedProperties;
  var diagram = this._diagram;
  var isPart = this.inspectedObject instanceof go.Part;
  var data = isPart ? this.inspectedObject.data : this.inspectedObject;
  if (!data) {  // Limpiar todos los campos
    for (var name in inspectedProps) {
      var input = inspectedProps[name];
      if (input.type === "color") {
        input.value = "#000000";
      } else {
        input.value = "";
      }

    }
  } else {
    for (var name in inspectedProps) {
      var input = inspectedProps[name];
      var propertyValue = data[name];
      if (input.type === "color") {
        input.value = this.setColor(propertyValue);
      } else {
        input.value = propertyValue;
      }
    }
  }
}

/**
* @ignore
* Actualice todas las propiedades de datos de {@link #inspectedObject} de acuerdo con la
* Valores actuales contenidos en los elementos de entrada HTML.
*/
Inspector.prototype.updateAllProperties = function() {
  var inspectedProps = this._inspectedProperties;
  var diagram = this._diagram;
  var isPart = this.inspectedObject instanceof go.Part;
  var data = isPart ? this.inspectedObject.data : this.inspectedObject;
  if (!data) return;  // No debe intentar actualizar datos cuando no hay datos!

  diagram.startTransaction("set all properties");
  for (var name in inspectedProps) {
    var value = inspectedProps[name].value;

    // No actualizar las propiedades de datos "readOnly"
    var decProp = this.declaredProperties[name];
    if (!this.canEditProperty(name, decProp, this.inspectedObject)) continue;

    // Si es un booleano, o si su valor anterior era booleano,
    // Analizar el valor para ser un booleano y luego actualizar el input.value para que coincida
    var type = "";
    if (decProp !== undefined && decProp.type !== undefined) {
      type = decProp.type;
    }
    if (type === "" && typeof data[name] === "boolean") type = "boolean"; // infer boolean

    // Convertir a tipo específico, si es necesario
    switch (type) {
      case "boolean":
        value = !(value == false || value === "false" || value === "0");
        break;
      case "number":
        value = parseFloat(value);
        break;
    }

    // En caso de que se analiza como diferente, como en el caso de valores booleanos,
    // El valor mostrado debe coincidir con el valor real
    inspectedProps[name].value = value;

    // Modificar el objeto de datos de una manera deshacer
    diagram.model.setDataProperty(data, name, value);

    // Notificar a cualquier oyente
    if (this.propertyModified !== null) this.propertyModified(name, value);
  }
  diagram.commitTransaction("set all properties");
};
