window.addEventListener('load', function() {
    handleTypeChange();

    document.getElementById('product_form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        clearErrors(); // Clear previous error messages

        const formData = new FormData(this);

        fetch('http://127.0.0.1/scandiweb/project-root/api/addProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('success').innerHTML = data.message;

                // Clear previous error messages
                clearErrors();
        
                setTimeout(function() {
                    window.location.href = "http://127.0.0.1/scandiweb/project-root/index.php";
                }, 1000);
            } else {
                window.errors['sku'] = data.message;
                displayErrors(window.errors);
            }
        })
        .catch(error => {
            console.log('Error:', error);
        });

        validateForm(); // Validate form inputs

        // Return false if there are errors
        return Object.keys(window.errors).length === 0;
    });
})

const fieldSettings = {
    'DVD': {
        fields: `
            <label for="size">Size (MB):</label>
            <input type="number" id="size" name="size" step="0.01" required><br>
        `,
        description: '<p>Please, provide size.</p>'
    },
    'Book': {
        fields: `
            <label for="weight">Weight (KG):</label>
            <input type="number" id="weight" name="weight" step="0.01" required><br>
        `,
        description: '<p>Please, provide weight.</p>'
    },
    'Furniture': {
        fields: `
            <label for="height">Height (CM):</label>
            <input type="number" id="height" name="height" step="0.01" required><br>
            <label for="width">Width (CM):</label>
            <input type="number" id="width" name="width" step="0.01" required><br>
            <label for="length">Length (CM):</label>
            <input type="number" id="length" name="length" step="0.01" required><br>
        `,
        description: '<p>Please, provide dimensions.</p>'
    }
};

window.errors = {};

function handleTypeChange() {
    const type = document.getElementById('type')?.value;
    const typeSpecificFields = document.getElementById('type_specific_fields');
    const dynamicDescription = document.getElementById('dynamic-description');
    
    // Clear previous fields and descriptions
    typeSpecificFields.innerHTML = '';
    dynamicDescription.innerHTML = '';

    typeSpecificFields.innerHTML = fieldSettings[type]?.fields || '';
    dynamicDescription.innerHTML = fieldSettings[type]?.description || '';
}

// Validate form inputs and display error messages
function validateForm() {
    const sku = document.getElementById('sku').value;
    const name = document.getElementById('name').value;
    const price = document.getElementById('price').value;
    const type = document.getElementById('type').value;

    window.errors = {}; // Clear previous errors

    // Validation logic
    var validations = {
        sku: () => sku.trim() === '' ? 'Please, submit required data' : '',
        name: () => {
            if (name.trim() === '') {
                return 'Please, submit required data.';
            } else if (!/^[a-zA-Z\s]+$/.test(name)) {
                return 'Please, provide the data of indicated type for Name.';
            }
            return '';
        },
        price: () => {
            if (price.trim() === '') {
                return 'Please, submit required data.';
            } else if (isNaN(price) || price < 0) {
                return 'Please, provide the data of indicated type for Price.';
            }
            return '';
        },
        type: () => type === '' ? 'Please, submit required data.' : ''
    };

    Object.keys(validations).forEach(key => {
        const error = validations[key]();
        if (error) {
            window.errors[key] = error;
        }
    });

    if (Object.keys(window.errors).length) {
        displayErrors(window.errors); // Display new error messages
    }
}

// Clear previous error messages
function clearErrors() {
    document.getElementById('sku-error').innerHTML = '';
    document.getElementById('name-error').innerHTML = '';
    document.getElementById('price-error').innerHTML = '';
    document.getElementById('type-error').innerHTML = '';
    window.errors = {};
}

// Display error messages
function displayErrors(errors) {
    Object.keys(errors).forEach(key => {
        document.getElementById(`${key}-error`).innerHTML = errors[key];
    });
}

// Handle mass deletion of products
function massDelete() {
    const checkboxes = document.querySelectorAll('.delete-checkbox');
    const checkedBoxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);
    const errorMessage = document.querySelector('.error-message');
    const successMessage = document.getElementById('success-message');

    if (checkedBoxes.length > 0) {
        errorMessage.style.display = 'none';
        document.getElementById('product_list').submit();
        // Display success message
        successMessage.style.display = 'block';
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 2000); // Hide after 2 seconds
    } else {
        errorMessage.textContent = 'You should select a product to delete.';
        errorMessage.style.display = 'block';
    }
}
