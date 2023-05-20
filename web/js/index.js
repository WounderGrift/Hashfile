export class index
{
    constructor()
    {
        this.fileInput = document.getElementById('file');
        this.clearBtn  = document.getElementById('clear');
    }

    fileSelect(event)
    {
        const selectedFile = event.target.files[0];
        $('[for=file]').text(selectedFile.name);

        console.log('Selected file:', selectedFile);
    }

    clearAll()
    {
        $('#name').val('');
        $('#description').val('');
        $('[for=file]').text('Выберите файл').val(null);
    }

    attachEvent()
    {
        this.fileInput.addEventListener('change', this.fileSelect);
        this.clearBtn.addEventListener('click', this.clearAll);
    }
}

const indexBase = new index().attachEvent();