import Swal from "sweetalert2";
import "preline";

window.Swal = Swal;

Document.addEventListener("livewire:navigated", () => {
    window.HSStaticMethods.autoInit();
});
