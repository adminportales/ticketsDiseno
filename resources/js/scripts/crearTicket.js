if (document.querySelector('#dropzoneItems')) {
    let items = new Set()
    let products = new Set()
    let logos = new Set()
    Dropzone.autoDiscover = false;
    document.addEventListener('DOMContentLoaded', () => {
        // Dropzone
        const dropzoneItem = new Dropzone('#dropzoneItems', {
            url: "/tickets/items",
            dictDefaultMessage: 'Arrastra aqui los archivos para tu solicitud, imagenes, PDF`s, etc.',
            //acceptedFiles: '.pdf,.png,.jpg,.jpeg,.gif,.bmp',
            addRemoveLinks: true,
            dictRemoveFile: 'Borrar Archivo',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            init: function () {
                const itemsOld = document.querySelector('#items').value.split(',')
                if (document.querySelector('#items').value.trim()) {
                    console.log(itemsOld);
                    let imagenPublicada = []
                    itemsOld.forEach((itemOld, index) => {
                        items.add(itemOld)
                        imagenPublicada[index] = {}
                        imagenPublicada[index].size = 1024;
                        imagenPublicada[index].name = itemOld

                        this.options.addedfile.call(this, imagenPublicada[index])
                        this.options.thumbnail.call(this, imagenPublicada[index],
                            `/storage/items/${imagenPublicada[index].name}`)
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
                console.log(file);
                console.log(response);
                document.querySelector('#error').textContent = ''
                items.add(response.correcto)
                console.log(items);
                document.querySelector("#items").value = [...items];
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
                axios.post('/tickets/deleteItem', params)
                    .then(response => {
                        console.log(response.data);
                        if (items.has(response.data.imagen)) {
                            items.delete(response.data.imagen)
                            document.querySelector("#items").value = [...items];
                        }
                        console.log(items);
                    })
            }
        });
        const dropzoneProduct = new Dropzone('#dropzoneProduct', {
            url: "/tickets/upload-product",
            dictDefaultMessage: 'Selecciona o arrastra la imagen de tu producto',
            //acceptedFiles: '.pdf,.png,.jpg,.jpeg,.gif,.bmp',
            addRemoveLinks: true,
            dictRemoveFile: 'Borrar Archivo',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            init: function () {
                const productsOld = document.querySelector('#product').value.split(',')
                if (document.querySelector('#product').value.trim()) {
                    console.log(productsOld);
                    let imagenPublicada = []
                    productsOld.forEach((itemOld, index) => {
                        products.add(itemOld)
                        imagenPublicada[index] = {}
                        imagenPublicada[index].size = 1024;
                        imagenPublicada[index].name = itemOld

                        this.options.addedfile.call(this, imagenPublicada[index])
                        this.options.thumbnail.call(this, imagenPublicada[index],
                            `/storage/products/${imagenPublicada[index].name}`)
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
                console.log(file);
                console.log(response);
                document.querySelector('#error').textContent = ''
                products.add(response.correcto)
                console.log(products);
                document.querySelector('#product').value = [...products];
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
                axios.post('/tickets/deleteProduct', params)
                    .then(response => {
                        console.log('datos de elimia');
                        console.log(response.data);
                        if (products.has(response.data.imagen)) {
                            products.delete(response.data.imagen)
                            document.querySelector('#product').value = [...products];
                        }
                        console.log(products);
                    })
            }
        });
        const dropzoneLogo = new Dropzone('#dropzoneLogo', {
            url: "/tickets/upload-logo",
            dictDefaultMessage: 'Selecciona o arrastra tu logo, para una respuesta mas rapida, es indispensable que el logo este en curvas',
            //acceptedFiles: '.pdf,.jpg,.jpeg,.gif,.bmp',
            addRemoveLinks: true,
            dictRemoveFile: 'Borrar Archivo',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            init: function () {
                const logosOld = document.querySelector('#logo').value.split(',')
                if (document.querySelector('#logo').value.trim()) {
                    console.log(logosOld);
                    let imagenPublicada = []
                    logosOld.forEach((itemOld, index) => {
                        logos.add(itemOld)
                        imagenPublicada[index] = {}
                        imagenPublicada[index].size = 1024;
                        imagenPublicada[index].name = itemOld

                        this.options.addedfile.call(this, imagenPublicada[index])
                        this.options.thumbnail.call(this, imagenPublicada[index],
                            `/storage/logos/${imagenPublicada[index].name}`)
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
                console.log(file);
                console.log(response);
                document.querySelector('#error').textContent = ''
                logos.add(response.correcto)
                console.log(logos);
                document.querySelector('#logo').value = [...logos];
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
                axios.post('/tickets/deleteLogo', params)
                    .then(response => {
                        console.log('datos de elimia');
                        console.log(response.data);
                        if (logos.has(response.data.imagen)) {
                            logos.delete(response.data.imagen)
                            document.querySelector('#logo').value = [...logos];
                        }
                        console.log(logos);
                    })
            }
        });
    })
}
