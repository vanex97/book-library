formFile.onchange = evt => {
    const [file] = formFile.files
    if (file) {
        if (!$('#inserted_image').length) {
            $('<img/>')
                .attr('id', 'inserted_image')
                .attr('src', '#')
                .attr('alt', 'inserted image')
                .addClass('mb-2')
                .insertAfter('.img-input');
        }
        inserted_image.src = URL.createObjectURL(file);
    }
}