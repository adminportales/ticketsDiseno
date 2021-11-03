if (document.querySelector('#formCreate')) {
    const selectType = document.querySelector('#type')

    const logoElement = document.querySelector('#logoElement')
    const itemsElement = document.querySelector('#itemsElement')
    const productElement = document.querySelector('#productElement')
    const pantoneElement = document.querySelector('#pantone')
    const tecnicaElement = document.querySelector('#tecnica')
    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('#message')) {
            const message = document.querySelector('#message')
            setTimeout(() => {
                message.remove()
            }, 5000);
        }
        alert(logoElement)
        selectType.addEventListener('change', () => {

            switch (selectType.value) {
                case 1:
                    itemsElement.classList.add('d-none')
                    break;
                case 2:

                    break;
                case 3:

                    break;

                default:
                    break;
            }
        })
    })
}
