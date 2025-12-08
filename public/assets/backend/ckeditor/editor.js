const data ={
    csrf: $('meta[name="csrf-token"]').attr("content"),
}
const config = {
    width: 'auto',
    height: 350,
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=' + data.csrf,
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=' + data.csrf
};
if (CKEDITOR.env.ie && CKEDITOR.env.version < 9) {
    CKEDITOR.tools.enableHtml5Elements(document);
}
$(".ckEditor").each(function () {
    const editorElement = CKEDITOR.document.getById(this.id);
    const editor = createEditor(this.id, config);
    if (!hasWysiwygArea()) {
        makeInline(editorElement);
    }
});

function createEditor(id, config) {
    return CKEDITOR.replace(id, config);
}

function hasWysiwygArea() {
    if (CKEDITOR.revision === ('%RE' + 'V%')) {
        return true;
    }
    return !!CKEDITOR.plugins.get('wysiwygarea');
}

function makeInline(editorElement) {
    editorElement.setAttribute('contenteditable', 'true');
    CKEDITOR.inline(editorElement);
}
