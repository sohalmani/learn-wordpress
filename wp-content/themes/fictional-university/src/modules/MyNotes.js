import $ from "jquery";

class MyNotes {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        $('.create-note').on('click', '.submit-note', this.createNote.bind(this));
        $('#my-notes').on('click', '.edit-note', this.editNote.bind(this));
        $('#my-notes').on('click', '.update-note', this.updateNote.bind(this));
        $('#my-notes').on('click', '.delete-note', this.deleteNote.bind(this));
    }

    createNote(e) {
        $.ajax({
            url: `${FictionalUniversityData.rootUrl}/wp-json/wp/v2/note`,
            type: 'POST',
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', FictionalUniversityData.nonce);
            },
            data: {
                'title': $('.create-note').find('.new-note-title').val(),
                'content': $('.create-note').find('.new-note-body').val(),
                'status': 'publish'
            }
        }).done((response) => {
            console.log('Yay!', response);
            $('.new-note-title, .new-note-body').val('');
            $(`
                <li data-id="${response.id}">
                    <input type="text" class="note-title-field" value="${response.title.raw}" readonly>
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea class="note-body-field" cols="30" rows="10" readonly>${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                </li>
            `).prependTo('#my-notes').hide().slideDown();
        }).fail((response) => {
            console.log('Oops!', response);
            if (response.responseText === 'Note Limit Exceed') {
                $('.note-limit-message').addClass('active');
            }
        });
    }

    editNote(e) {
        const thisNote = $(e.target).closest('li');

        if (thisNote.data('state') !== 'editable') {
            this.makeNoteEditable(thisNote);
        } else {
            this.makeNoteReadOnly(thisNote);
        }
    }

    updateNote(e) {
        const thisNote = $(e.target).closest('li');

        $.ajax({
            url: `${FictionalUniversityData.rootUrl}/wp-json/wp/v2/note/${thisNote.data('id')}`,
            type: 'POST',
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', FictionalUniversityData.nonce);
            },
            data: {
                'title': thisNote.find('.note-title-field').val(),
                'content': thisNote.find('.note-body-field').val(),
            }
        }).done((response) => {
            console.log('Yay!', response);
            this.makeNoteReadOnly(thisNote);
        }).fail((response) => {
            console.log('Oops!', response);
        });
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
            if (response.count_users_notes < 5) {
                $('.note-limit-message').removeClass('active');
            }
            thisNote.slideUp(function () {
                thisNote.remove();
            });
        }).fail((response) => {
            console.log('Oops!', response);
        });
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
}

export default MyNotes;