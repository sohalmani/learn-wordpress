import $ from "jquery";

class MyNotes {
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        $('.delete-note').on('click', this.deleteNote.bind(this));
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