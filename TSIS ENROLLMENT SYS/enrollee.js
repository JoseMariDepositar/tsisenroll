
document.getElementById("requirements_form").addEventListener("submit", function(event) {
    const lrn = document.getElementById("lrn").value;

    const files = [
        { input: document.getElementById("1x1_photo"), type: "1x1_photo" },
        { input: document.getElementById("form_137"), type: "form_137" },
        { input: document.getElementById("form_138"), type: "form_138" },
        { input: document.getElementById("good_moral"), type: "good_moral" },
        { input: document.getElementById("birth_certificate"), type: "birth_certificate" },
    ];

    for (const file of files) {
        const fileName = file.input.value.split("\\").pop(); // Get the file name
        const expectedName = `${lrn}_${file.type}`; // Expected naming format

        // Check if the file name matches the expected format
        if (!fileName.startsWith(expectedName)) {
            alert(`Please name your file for ${file.type} as "${expectedName}.extension"`);
            event.preventDefault(); // Prevent form submission
            return;
        }
    }
});

function validateStep(stepNumber) {
    // Get the current form section
    const currentStep = document.getElementById('step-' + stepNumber);
    const inputs = currentStep.querySelectorAll('input[required], select[required]');

    // Check if all required inputs are filled
    let isValid = true;
    inputs.forEach(input => {
        if (!input.value) {
            isValid = false;
            input.style.borderColor = "red";  // Highlight missing fields
        } else {
            input.style.borderColor = "";  // Reset if filled
        }
    });

    return isValid;
}

function nextStep(stepNumber) {
    // Validate current step before moving to the next one
    const valid = validateStep(stepNumber - 1);

    if (valid) {
        // Hide all sections
        const sections = document.querySelectorAll('.form-section');
        sections.forEach(section => {
            section.classList.remove('active');
        });

        // Show the specific step
        const targetStep = document.getElementById('step-' + stepNumber);
        targetStep.classList.add('active');
    } else {
        alert("Please fill out all required fields.");
    }
}
// AGE CALCULATOR FNC
function calculateAge() {
    const dobInput = document.getElementById('birthday').value;
    const dob = new Date(dobInput);
    const today = new Date();

    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();

    // Adjust age if the birthday hasn't occurred yet this year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    document.getElementById('age').value = age; // Set the calculated age
}

