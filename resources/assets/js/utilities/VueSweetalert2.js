import swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const swalPlugin = {}

swalPlugin.install = function(Vue){
    Vue.prototype.$swal = swal
}

export default swalPlugin;