import $ from 'jquery';

class Search {
    constructor() {
        this.appendSearchOverlay();

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

    appendSearchOverlay() {
        $('body').append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" name="search-term" id="search-term" class="search-term"
                               placeholder="So, what are you looking for?" autocomplete="off">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="container">
                    <div id="search-overlay__results"></div>
                </div>
            </div>
        `);
    }

    openOverlay() {
        this.searchOverlay.toggleClass('search-overlay--active');
        $('body').toggleClass('body-no-scroll');
        this.searchInput.val('');
        setTimeout(() => this.searchInput.focus(), 400);
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpen = false;
    }

    getResults() {
        $.when(
            $.getJSON(`${FictionalUniversityData.rootUrl}/wp-json/wp/v2/posts?search=${this.searchInput.val()}`),
            $.getJSON(`${FictionalUniversityData.rootUrl}/wp-json/wp/v2/pages?search=${this.searchInput.val()}`)
        ).then((posts, pages) => {
            const combinedResults = posts[0].concat(pages[0]);

            this.searchResultsContainer.html(`
                <h2 class="search-overlay__section-title">General Information</h2>
                ${combinedResults.length ? `
                    <ul class="link-list min-list">
                        ${combinedResults.map((result) => `<li>
                            <a href="${result.link}">${result.title.rendered}</a>
                            ${result.type === 'post' ? ` by ${result.author_name}` : ``}
                        </li>`).join('')}
                    </ul>
                ` : `
                    <p>No Results Found</p>
                `}
            `);

            this.isSpinnerVisible = false;
        }, () => {
            this.searchResultsContainer.html(`<p>Unexpected Error occured! Please contact support.</p>`);
        });
    }
}

export default Search;