import './bootstrap';
import $ from 'jquery';
import 'jquery-validation';
import 'datatables.net-dt';
import { createIcons, icons } from 'lucide';

window.$ = window.jQuery = $;
window.createIcons = createIcons;
window.icons = icons;

if (typeof $ !== 'undefined') {
    console.log("jQuery está funcionando correctamente.");
} else {
    console.error("Algo falló: jQuery no está definido.");
}

$(document).ready(function () {
    createIcons({ icons });

    $("#usersTable").DataTable({
        language: {
            processing: "Procesando...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros en total)",
            infoPostFix: "",
            loadingRecords: "Cargando...",
            zeroRecords: "No se encontraron registros",
            emptyTable: "No hay datos disponibles en la tabla",
            aria: {
                sortAscending: ": Activar para ordenar de forma ascendente",
                sortDescending: ": Activar para ordenar de forma descendente"
            },
            buttons: {
                copy: "Copiar",
                colvis: "Visibilidad",
                csv: "Exportar a CSV",
                excel: "Exportar a Excel",
                pdf: "Exportar a PDF",
                print: "Imprimir"
            },
            select: {
                rows: {
                    _: "Has seleccionado %d filas",
                    0: "Haz clic en una fila para seleccionarla",
                    1: "Has seleccionado 1 fila"
                }
            },
            decimal: ",",
            thousands: "."
        }
    });
});
