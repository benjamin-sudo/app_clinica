<select id="listarMenup" class="form-select form-select-sm" onchange="muestraDirAr();">
    <option value="0">Nueva Entrada</option>
    <?php if (count($menu_principal) > 0) {
        foreach ($menu_principal as $mainMenu) {
            // Datos del menú principal
            $mainData = $mainMenu['data'];
            echo "<option value='" . htmlspecialchars($mainData['main_id']) . "' " . ($mainData['main_tipo'] == "2" ? "disabled" : "") . " data-info='" . htmlspecialchars(json_encode($mainData), ENT_QUOTES, 'UTF-8') . "' data-tipo='0'>";
            echo "(MENU PRINCIPAL) " . htmlspecialchars($mainData['main_nombre']);
            echo "</option>";
            // Iterar sobre los submenús
            foreach ($mainMenu['submenus'] as $subMenu) {
                $subData = $subMenu['data'];
                echo "<option value='" . htmlspecialchars($subData['sub_id']) . "' " . ($subData['sub_tipo'] == "2" ? "disabled" : "") . " data-info='" . htmlspecialchars(json_encode($subData), ENT_QUOTES, 'UTF-8') . "' data-tipo='1'>";
                echo "&nbsp;&nbsp;∟ SUB MENU " . htmlspecialchars($subData['sub_nombre']);
                echo "</option>";

                // Iterar sobre las extensiones
                foreach ($subMenu['extensions'] as $extension) {
                    echo "<option value='" . htmlspecialchars($extension['ext_id']) . "' " . ($extension['ext_tipo'] == "2" ? "disabled" : "") . " data-info='" . htmlspecialchars(json_encode($extension), ENT_QUOTES, 'UTF-8') . "' data-tipo='3'>";
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(EXTENSION) " . htmlspecialchars($extension['ext_nombre']);
                    echo "</option>";
                }
            }
        }
    } ?>
</select> 

