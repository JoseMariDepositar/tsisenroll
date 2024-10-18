// POP UP MESSAGE FOR SUMISSION OF REQ. STUD. APPLICATION

const openPopupBtn = document.getElementById('openPopup');
const closePopupBtn = document.getElementById('closePopup');
const popup = document.getElementById('popup');

openPopupBtn.addEventListener('click', function() {
    popup.classList.add('popup-visible');
});

closePopupBtn.addEventListener('click', function() {
    popup.classList.remove('popup-visible');
});

popup.addEventListener('click', function(e) {
    if (e.target === popup) {
        popup.classList.remove('popup-visible');
    }
});

// APPROVED STUD. FILLING FORM
function validateAndProceed() {
    const fatherForm = document.getElementById('fatherForm');

    // Check if all fields in the form are valid
    if (fatherForm.checkValidity()) {
        // Hide Father's information section
        document.getElementById('father-info').style.display = 'none';

        // Show Mother's information section
        document.getElementById('mother-info').style.display = 'block';
    } else {
        // Show native HTML5 form validation feedback
        fatherForm.reportValidity();
    }
}


//BURGER NENU FUNC TOGGLE MENU
function toggleMenu() {
    var navLinks = document.getElementById('navLinks');
    if (navLinks.style.display === 'flex') {
        navLinks.style.display = 'none';
    } else {
        navLinks.style.display = 'flex';
    }
}

