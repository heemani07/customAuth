/* ===============================
   NAVIGATION MENU
=================================*/
const nav = document.querySelector('nav');
const hamburger_menu = document.querySelector('.hamburger-menu-wrap');
const close_icon = document.querySelector('.nav-close-icon');

if (hamburger_menu && nav && close_icon) {
    hamburger_menu.addEventListener('click', () => nav.classList.add('open'));
    close_icon.addEventListener('click', () => nav.classList.remove('open'));
}

/* ===============================
   CUSTOM DROPDOWN
   Source: https://andrejgajdos.com/custom-select-dropdown/
=================================*/
document.querySelectorAll(".custom-select-wrapper").forEach(dropdown => {
    dropdown.addEventListener('click', function () {
        this.querySelector('.custom-select').classList.toggle('open');
    });
});

document.querySelectorAll(".custom-option").forEach(option => {
    option.addEventListener('click', function () {
        const selected = this.parentNode.querySelector('.custom-option.selected');
        if (selected) selected.classList.remove('selected');
        this.classList.add('selected');
        const trigger = this.closest('.custom-select').querySelector('.custom-select__trigger span');
        trigger.textContent = this.textContent;
    });
});

window.addEventListener('click', e => {
    document.querySelectorAll('.custom-select').forEach(select => {
        if (!select.contains(e.target)) {
            select.classList.remove('open');
        }
    });
});

/* ===============================
   CUSTOM DATE PICKER
   Source: https://github.com/TylerPottsDev/custom-date-picker
=================================*/
const date_picker_element = document.querySelector('.date-picker');
if (date_picker_element) {
    const selected_date_element = date_picker_element.querySelector('.selected-date');
    const dates_element = date_picker_element.querySelector('.dates');
    const mth_element = date_picker_element.querySelector('.month .mth');
    const next_mth_element = date_picker_element.querySelector('.month .next-mth');
    const prev_mth_element = date_picker_element.querySelector('.month .prev-mth');
    const days_element = date_picker_element.querySelector('.days');

    const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    let date = new Date();
    let day = date.getDate();
    let month = date.getMonth();
    let year = date.getFullYear();

    let selectedDate = date;
    let selectedDay = day;
    let selectedMonth = month;
    let selectedYear = year;

    mth_element.textContent = `${months[month]} ${year}`;
    selected_date_element.textContent = formatDate(date);
    selected_date_element.dataset.value = selectedDate;

    populateDates();

    date_picker_element.addEventListener('click', e => {
        if (!e.target.closest('.dates')) {
            dates_element.classList.toggle('active');
        }
    });

    next_mth_element.addEventListener('click', () => {
        month++;
        if (month > 11) {
            month = 0;
            year++;
        }
        mth_element.textContent = `${months[month]} ${year}`;
        populateDates();
    });

    prev_mth_element.addEventListener('click', () => {
        month--;
        if (month < 0) {
            month = 11;
            year--;
        }
        mth_element.textContent = `${months[month]} ${year}`;
        populateDates();
    });

    document.addEventListener('click', e => {
        if (!date_picker_element.contains(e.target)) {
            dates_element.classList.remove('active');
        }
    });

    function populateDates() {
        days_element.innerHTML = '';
        let amount_days = 31;

        // Handle February (leap year support)
        if (month === 1) {
            amount_days = (year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) ? 29 : 28;
        }

        // Handle months with 30 days
        if ([3, 5, 8, 10].includes(month)) amount_days = 30;

        for (let i = 1; i <= amount_days; i++) {
            const day_element = document.createElement('div');
            day_element.classList.add('day');
            day_element.textContent = i;

            if (selectedDay === i && selectedYear === year && selectedMonth === month) {
                day_element.classList.add('selected');
            }

            day_element.addEventListener('click', () => {
                selectedDate = new Date(`${year}-${month + 1}-${i}`);
                selectedDay = i;
                selectedMonth = month;
                selectedYear = year;

                selected_date_element.textContent = formatDate(selectedDate);
                selected_date_element.dataset.value = selectedDate;

                populateDates();
            });

            days_element.appendChild(day_element);
        }
    }

    function formatDate(d) {
        let day = d.getDate().toString().padStart(2, '0');
        let month = (d.getMonth() + 1).toString().padStart(2, '0');
        let year = d.getFullYear();
        return `${day} / ${month} / ${year}`;
    }
}

/* ===============================
   TESTIMONIAL SLIDER
=================================*/
const previous = document.querySelector('#arrow-previous');
const next = document.querySelector('#arrow-next');
const testimonial_list = document.querySelectorAll('.testimonial-item');
const active = document.querySelector('.testimonial-item.active');
let index = 0;

if (previous && next && testimonial_list.length > 0 && active) {
    const toggleArrowPassive = () => {
        if (index === 0) {
            previous.classList.add("passive");
        } else {
            previous.classList.remove("passive");
        }
    };

    previous.addEventListener('click', () => {
        if (index < testimonial_list.length - 1) index++;
        toggleArrowPassive();
        active.style.marginLeft = `-${index}00%`;
    });

    next.addEventListener('click', () => {
        if (index > 0) index--;
        toggleArrowPassive();
        active.style.marginLeft = `-${index}00%`;
    });
}

/* ===============================
   SCROLL TO TOP
=================================*/
const arrowUp = document.querySelector('.arrow-up');
if (arrowUp) {
    arrowUp.addEventListener('click', () => {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });

    window.addEventListener('scroll', () => {
        arrowUp.style.opacity = (window.scrollY > 20 ? "1" : "0");
    });
}
