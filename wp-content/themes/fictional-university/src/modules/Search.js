import $ from 'jquery';

class Search {
    constructor() {
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.searchInput = $('#search-term');
        this.searchResultsContainer = $('#search-overlay__results');
        this.isOverlayOpen = false;
        this.searchTimeout = null;
        this.isSpinnerVisible = false;
        this.previousSearchValue = '';

        this.bindEvents();
    }

    bindEvents() {
        this.openButton.on('click', this.openOverlay.bind(this));
        this.closeButton.on('click', this.closeOverlay.bind(this))
        this.searchInput.on('keydown', this.handleSearchInput.bind(this));
        $(document).on('keydown', this.handleKeyUp.bind(this));
    }

    handleSearchInput(e) {
        if (this.searchInput.val().trim() != this.previousSearchValue) {
            clearTimeout(this.searchTimeout);

            if (this.searchInput.val()) {
                if (!this.isSpinnerVisible) {
                    this.searchResultsContainer.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }

                this.searchTimeout = setTimeout(this.getResults.bind(this), 1000);
            } else {
                this.searchResultsContainer.empty();
                this.isSpinnerVisible = false;
            }
        }

        this.previousSearchValue = this.searchInput.val().trim();
    }

    handleKeyUp(e) {
        if (e.keyCode === 83 && !this.isOverlayOpen && !$('input, textarea').is(':focus')) {
            this.openOverlay();
        }

        if (e.keyCode === 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
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

    getResults() {
        this.searchResultsContainer.html('This is our search results!');
        this.isSpinnerVisible = false;
    }
}

export default Search;