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
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

const getImageNameFromResponse = (file, response) => {
    if (response?.imagen) {
        return response.imagen;
    }

    if (typeof response === 'string') {
        try {
            const parsed = JSON.parse(response);
            if (parsed?.imagen) {
                return parsed.imagen;
            }
        } catch (error) {
            return response.trim();
        }
    }

    if (file?.xhr?.response) {
        try {
            const parsed = JSON.parse(file.xhr.response);
            if (parsed?.imagen) {
                return parsed.imagen;
            }
        } catch (error) {
            return '';
        }
    }

    return '';
};

if (dropzoneElement) {
    const dropzone = new Dropzone(dropzoneElement, {
        dictDefaultMessage: 'Sube aquí tu imagen',
        acceptedFiles: '.png,.jpg,.jpeg,.gif,.webp,.bmp,.PNG,.JPG,.JPEG,.GIF,.WEBP,.BMP',
        addRemoveLinks: true,
        dictRemoveFile: 'Borrar archivo',
        maxFiles: 1,
        uploadMultiple: false,
        paramName: 'file',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },

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
        const imageName = getImageNameFromResponse(file, response);

        if (imagenInput && imageName) {
            imagenInput.value = imageName;
            file.previewElement?.classList.remove('dz-error');
        } else {
            this.emit('error', file, 'No pudimos leer el nombre del archivo devuelto por el servidor.');
        }
    });
    
    dropzone.on('removedfile', function(){
        if (imagenInput) {
            imagenInput.value = '';
        }
    });

    dropzone.on('error', function(file, errorMessage) {
        const message = typeof errorMessage === 'string'
            ? errorMessage
            : errorMessage?.errors?.file?.[0]
                ?? 'No se pudo subir la imagen, inténtalo de nuevo.';

        if (file?.previewElement) {
            const errorNode = file.previewElement.querySelector('[data-dz-errormessage]');
            if (errorNode) {
                errorNode.textContent = message;
            }
        }

        if (imagenInput) {
            imagenInput.value = '';
        }
    });
}
