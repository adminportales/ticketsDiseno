if (document.querySelector('#dropzoneDelivery')) {
    let delivery = new Set()
    Dropzone.autoDiscover = false;
    document.addEventListener('DOMContentLoaded', () => {
        // Dropzone
        const dropzoneDelivery = new Dropzone('#dropzoneDelivery', {
            url: "/tickets/delivery",
            dictDefaultMessage: 'Arrastra aqui los archivos de entrega',
            acceptedFiles: '.png,.jpg,.jpeg,.gif,.bmp',
            addRemoveLinks: true,
            dictRemoveFile: 'Borrar Archivo',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            init: function () {
                const itemsOld = document.querySelector('#delivery').value.split(',')
                if (document.querySelector('#delivery').value.trim()) {
                    console.log(deliveryOld);
                    let imagenPublicada = []
                    deliveryOld.forEach((itemOld, index) => {
                        delivery.add(itemOld)
                        imagenPublicada[index] = {}
                        imagenPublicada[index].size = 1024;
                        imagenPublicada[index].name = itemOld

                        this.options.addedfile.call(this, imagenPublicada[index])
                        this.options.thumbnail.call(this, imagenPublicada[index],
                            `/storage/deliveries/${imagenPublicada[index].name}`)
                        imagenPublicada[index].previewElement.classList.add('dz-success')
                        imagenPublicada[index].nombreServidor = itemOld
                        //imagenPublicada[index].previewElement.classList.add('complete')
                        imagenPublicada[index].previewElement.children[2].classList.add(
                            'd-none')
                        imagenPublicada[index].previewElement.children[0].children[0]
                            .classList.add('w-100')
                    });
                }
            },
            success: function (file, response) {
                console.log('imprimir ela rchivo')
                console.log(file);
                console.log(response);
                document.querySelector('#error').textContent = ''
                delivery.add(response.correcto)
                console.log(delivery);
                document.querySelector("#delivery").value = [...delivery];
                // Add al objeto de archivo, el nombre de la imagen en el servidor
                file.nombreServidor = response.correcto
                // file.previewElement.parentNode.removeChild(file.previewElement)
            },
            error: function (file, response) {
                // console.log(response);
                // console.log(file);
                document.querySelector('#error').textContent = 'Formato no valido'
            },
            removedfile: function (file, response) {
                file.previewElement.parentNode.removeChild(file.previewElement)
                // console.log(file);
                console.log('El archivo borrado fue');
                params = {
                    imagen: file.nombreServidor
                }
                // console.log(params);
                axios.post('/tickets/deleteDelivery', params)
                    .then(response => {
                        console.log(response.data);
                        if (delivery.has(response.data.imagen)) {
                            delivery.delete(response.data.imagen)
                            document.querySelector("#delivery").value = [...delivery];
                        }
                        console.log(delivery);
                    })
            }
        });
    })
}
