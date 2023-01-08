import $ from "jquery";

class MyNotes {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        $('.edit-note').on('click', this.editNote.bind(this));
        $('.delete-note').on('click', this.deleteNote.bind(this));
    }

    makeNoteEditable(thisNote) {
        thisNote.data('state', 'editable');
        thisNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
        thisNote.find('.update-note').addClass('update-note--visible');
    }

    makeNoteReadOnly(thisNote) {
        thisNote.data('state', 'readonly');
        thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        thisNote.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass('note-active-field');
        thisNote.find('.update-note').removeClass('update-note--visible');
    }

    editNote(e) {
        const thisNote = $(e.target).closest('li');

        if (thisNote.data('state') !== 'editable') {
            this.makeNoteEditable(thisNote);
        } else {
            this.makeNoteReadOnly(thisNote);
        }
    }

    deleteNote(e) {
        const thisNote = $(e.target).closest('li');

        $.ajax({
            url: `${FictionalUniversityData.rootUrl}/wp-json/wp/v2/note/${thisNote.data('id')}`,
            type: 'DELETE',
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', FictionalUniversityData.nonce);
            },
        }).done((response) => {
            console.log('Yay!', response);
            thisNote.slideUp(function () {
                thisNote.remove();
            });
        }).fail((message) => {
            console.log('Oops!', message);
        });
    }
}

export default MyNotes;