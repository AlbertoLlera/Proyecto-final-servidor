/*
    DropZone es una librería de JavaScript que permite subir archivos.
    En este caso lo vamos a utilizar para subir imágenes de un manera rápida y sencilla.
    Como podemos comprobar en las siguiente líneas, hemos definido la configuración,
    De esta manera permitimos una sola imagen por subida y además definimos los tipos de archivos que estñan permitidos.
*/

import './bootstrap';
import Dropzone from 'dropzone';
Dropzone.autoDiscover = false;

const dropzoneElement = document.querySelector('#dropzone');
const imagenInput = document.querySelector('#imagen');

if (dropzoneElement) {
    const dropzone = new Dropzone(dropzoneElement, {
        dictDefaultMessage: 'Sube aquí tu imagen',
        acceptedFiles: '.png,.jpg,.jpeg,.gif,.bmp',
        addRemoveLinks: true,
        dictRemoveFile: 'Borrar archivo',
        maxFiles: 1,
        uploadMultiple: false,

        init: function () {
            if (imagenInput?.value.trim()) {
                const mockFile = { name: imagenInput.value, size: 1234 };
                this.options.addedfile.call(this, mockFile);
                this.options.thumbnail.call(this, mockFile, `/storage/uploads/${mockFile.name}`);
                mockFile.previewElement.classList.add('dz-success', 'dz-complete');
            }
        }
    });

    dropzone.on('success', function (file, response) {
        if (imagenInput && response?.imagen) {
            imagenInput.value = response.imagen;
        }
    });
    
    dropzone.on('removedfile', function(){
        if (imagenInput) {
            imagenInput.value = '';
        }
    });
}
