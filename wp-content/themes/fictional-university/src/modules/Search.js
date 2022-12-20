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
        $.getJSON(`${FictionalUniversityData.rootUrl}/wp-json/university/v1/search?term=${this.searchInput.val()}`, (results) => {
            //language=HTML
            this.searchResultsContainer.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.general_info.length ? `
                        <ul class="link-list min-list">
                            ${results.general_info.map((result) => `
                            <li>
                                <a href="${result.permalink}">${result.title}</a>
                                ${result.postType === 'post' ? ` by ${result.author_name}` : ``}
                            </li>`).join('')}
                        </ul>
                        ` : `
                        <p>No General Information is available</p>
                        `}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? `
                        <ul class="link-list min-list">
                            ${results.programs.map((result) => `
                            <li>
                                <a href="${result.permalink}">${result.title}</a>
                            </li>`).join('')}
                        </ul>
                        ` : `
                        <p>No Programs available</p>
                        `}
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length ? `
                        <ul class="link-list min-list">
                            ${results.professors.map((result) => `
                            <li class="professor-card__list-item">
                                <a href="${result.permalink}" class="professor-card">
                                    <img class="professor-card__image" src="${result.image}" alt="${result.title}">
                                    <span class="professor-card__name">${result.title}</span>
                                </a>
                            </li>`).join('')}
                        </ul>
                        ` : `
                        <p>No Professors found</p>
                        `}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length ? `
                        <ul class="link-list min-list">
                            ${results.events.map((result) => `
                            <li>
                                <div class="event-summary">
                                    <a class="event-summary__date t-center" href="${result.permalink}">
                                        <span class="event-summary__month">${result.month}</span>
                                        <span class="event-summary__day">${result.day}</span>
                                    </a>
                                    <div class="event-summary__content">
                                        <h5 class="event-summary__title headline headline--tiny">
                                            <a href="${result.permalink}">${result.title}</a>
                                        </h5>
                                        <p>
                                            ${result.description}
                                            <a href="${result.permalink}" class="nu gray">Learn more</a>
                                        </p>
                                    </div>
                                </div>
                            </li>`).join('')}
                        </ul>
                        ` : `
                        <p>No Events found</p>
                        `}
                    </div>
                </div>
            `);

            this.isSpinnerVisible = false;
        });
    }
}

export default Search;