<?php
$this->title = 'Hash file library application';
?>

<link rel="stylesheet" href="css/index.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>


<div class="site-index" id="app">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Форма загрузки файла</h1>

        <form onsubmit="return false;">
        <div class="form-container">
            <div class="form-group">
                <label for="name">Название:</label>
                <input type="text" v-model="nameModel" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea v-model="descriptionModel" class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <div class="custom-file">
                    <input type="file" style="cursor: pointer" @change="fileSelect"
                           class="custom-file-input" id="file" name="content" required>
                    <label class="custom-file-label" for="file">{{selectFile}}</label>
                </div>
            </div>

            <button @click="uploadFile()" class="btn btn-lg btn-success">Загрузить</button>
            <button @click="clearFields()" class="btn btn-lg btn-close"></button>
        </div>
        </form>
    </div>

    <div class="jumbotron text-center bg-transparent" style="margin-top: 30px" v-if="fileInDatabase && canDisplayInfo">
        <div class="jumbotron text-center bg-transparent">
            <h1 class="display-4">Информация о файле</h1>
            <div class="form-container">
                <table class="file-table">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th v-if="canDisplayContent">Content</th>
                        <th>Date Created</th>
                        <th>Report</th>
                    </tr>
                    <tr>
                        <td>{{fileInDatabase.name}}</td>
                        <td>{{fileInDatabase.description}}</td>
                        <td>{{fileInDatabase.type}}</td>
                        <td>{{fileInDatabase.size}}</td>
                        <td v-if="canDisplayContent"><img v-bind:src="this.fileModel" width="150" height="100"></td>
                        <td>{{fileInDatabase.date_create}}</td>
                        <td>{{fileInDatabase.info}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="module">
    const app = new Vue({
        el: '#app',
        data: {
            nameModel: '',
            descriptionModel: '',
            selectFile: 'Выберите файл',
            fileModel: null,
            fileInfo: '',
            fileInDatabase: null,
            canDisplayContent: false,
            target: null
        },
        methods: {
            fileSelect(ev)
            {
                this.canDisplayInfo    = false;
                this.canDisplayContent = false;

                this.target = ev.target;
                let files   = this.target.files;
                if (files[0] == null)
                    return;

                let fr    = new FileReader();
                fr.onload = () =>
                {
                    this.fileModel = fr.result;
                };

                fr.readAsDataURL(files[0]);

                this.fileInfo   = {
                    type: this.target.files[0].type,
                    size: this.target.files[0].size,
                };

                this.selectFile = files[0].name;
            },
            clearFields()
            {
                this.nameModel         = '';
                this.descriptionModel  = '';
                this.selectFile        = 'Выберите файл';
                this.fileModel         = null;
                this.fileInDatabase    = null;
                this.target.value      = '';

                this.canDisplayInfo    = false;
                this.canDisplayContent = false;
            },
            async uploadFile()
            {
                this.fileInDatabase = await $.ajax({
                    url: 'http://f0821472.xsph.ru/hashfile/web/files/upload',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        name:        this.nameModel,
                        description: this.descriptionModel,
                        type:        this.fileInfo.type,
                        size:        this.fileInfo.size,
                        content:     this.fileModel
                    },
                });

                this.canDisplayInfo    = !!this.fileInDatabase;
                this.canDisplayContent = this.isImage();
            },
            isImage()
            {
                let mimeTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                ];

                return mimeTypes.includes(this.fileInDatabase.type)
            }
        }
    });

</script>
