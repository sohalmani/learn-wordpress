import $ from 'jquery';

class Search {
    constructor() {
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.searchInput = $('#search-term');
        this.isOverlayOpen = false;
        this.searchTimeout = null;
        this.bindEvents();
    }

    bindEvents() {
        this.openButton.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this))
        this.searchInput.on('keydown', this.handleSearchInput.bind(this));
        $(document).on('keydown', this.handleKeyUp.bind(this));
    }

    openOverlay() {
        this.searchOverlay.toggleClass('search-overlay--active');
        $('body').toggleClass('body-no-scroll');
        this.searchInput.focus();
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpen = false;
    }

    handleSearchInput(e) {
        clearTimeout(this.searchTimeout);

        this.searchTimeout = setTimeout(function () {
            console.log(e.target.value);
        }, 2000);
    }

    handleKeyUp(e) {
        if (e.keyCode === 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {
            this.openOverlay();
        }

        if (e.keyCode === 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    }
}

export default Search;