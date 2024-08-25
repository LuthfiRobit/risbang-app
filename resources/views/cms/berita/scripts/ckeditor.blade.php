<script>
    "use strict";

    var KTFormsCKEditorClassic = (function() {
        var initClassicEditor = function() {
            ClassicEditor
                .create(document.querySelector('#kt_docs_ckeditor_classic'), {
                    toolbar: {
                        items: [
                            'heading', '|', 'bold', 'italic', 'link', '|',
                            'numberedList', 'bulletedList', '|', 'blockQuote', '|',
                            'mediaEmbed', '|',
                            'undo', 'redo', '|',
                        ]
                    },
                    removePlugins: [
                        'Image', 'ImageUpload', 'ImageCaption', 'ImageStyle',
                        'ImageToolbar', 'ImageInsert'
                    ],
                    language: 'en'
                })
                .then(editor => {
                    window.editorInstance = editor;
                    editor.ui.view.editable.element.parentElement.id = 'ckeditor-container';
                })
                .catch(error => {
                    console.error(error);
                });
        };

        var validateCKEditor = function() {
            var editor = window.editorInstance;
            var errorDiv = document.getElementById('ckeditor-error');
            if (editor) {
                var editorData = editor.getData();
                if (!editorData.trim()) {
                    errorDiv.style.display = 'block';
                    return false;
                } else {
                    errorDiv.style.display = 'none';
                }
            }
            return true;
        };

        return {
            init: function() {
                initClassicEditor();
            },
            validateCKEditor: validateCKEditor
        };
    })();

    document.addEventListener('DOMContentLoaded', function() {
        KTFormsCKEditorClassic.init();
    });
</script>
