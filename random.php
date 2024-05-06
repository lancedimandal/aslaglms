<style>
    /* Style for contact form container */
    .wpcf7 {
        width: 1184px;
        height: 678px;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-sizing: border-box;
        overflow: hidden;
    }

    /* Style for form headings */
    .wpcf7 h2 {
        margin-bottom: 15px;
        color: #222C68;
        font-size: 18px;
        font-family: "Playfair Display", sans-serif;
    }

    /* Style for labels on fields */
    .wpcf7 label {
        color: #5D5D5D;
        font-size: 14px;
        font-family: "Open Sans", sans-serif;
    }

    /* Style for input fields */
    .wpcf7 input[type="text"],
    .wpcf7 input[type="email"],
    .wpcf7 input[type="url"],
    .wpcf7 input[type="tel"],
    .wpcf7 textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Style for submit button */
    .wpcf7 input[type="submit"] {
        background-color: transparent;
        color: #5D5D5D;
        padding: 10px 20px;
        border: 2px solid #222C68;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-family: "Open Sans", sans-serif;
        display: block;
        margin: 0 auto;
    }

    /* Style for submit button on hover */
    .wpcf7 input[type="submit"]:hover {
        background-color: #222C68;
        color: white;
    }
</style>

<div class="contact-form">
    <h2>Learn More...</h2>
    <div class="row">
        <div class="col">
            <label for="first-name">First Name*</label>
            [text* first-name id:first-name placeholder "Enter your first name"]
        </div>
        <div class="col">
            <label for="last-name">Last Name*</label>
            [text* last-name id:last-name placeholder "Enter your last name"]
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email Address*</label>
            [email* email id:email placeholder "Enter your email address"]
        </div>
        <div class="col">
            <label for="phone-number">Phone Number</label>
            [tel phone-number id:phone-number placeholder "Enter your phone number"]
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="business-name">Business Name</label>
            [text business-name id:business-name placeholder "Enter your business name"]
        </div>
        <div class="col">
            <label for="business-website">Business Website</label>
            [url business-website id:business-website placeholder "Enter your business website"]
        </div>
    </div>
    <div class="row">
        <div class="col full-width">
            <label for="further-information">Further Information</label>
            [textarea further-information id:further-information placeholder "Enter any further information"]
        </div>
    </div>
    <div class="row">
        [submit "Submit"]
    </div>
</div>

<div class="contact-form">
    <div class="container">
        <h2>Learn More...</h2>
        <div class="row">
            <div class="col">
                <label for="first-name">First Name</label>
                [text* first-name id:first-name]
            </div>
        </div>
        <div class="col">
            <label for="last-name">Last Name<span>*</span></label>
            [text* last-name id:last-name]
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="email">Email Address</label>
            [email* email id:email]
        </div>
    </div>
    <div class="col">
        <label for="phone-number">Phone Number</label>
        [tel phone-number id:phone-number]
    </div>
</div>
<div class="row">
    <div class="col">
        <label for="business-name">Business Name</label>
        [text business-name id:business-name]
    </div>
</div>
<div class="col">
    <label for="business-website">Business Website</label>
    [url business-website id:business-website]
</div>
</div>
<div class="row-group">
    <div class="col full-width">
        <label for="further-information">Further Information</label>
        [textarea further-information id:further-information]
    </div>
</div>
<div class="row">
    [submit "Submit"]
</div>
</div>
</div>

<div class="contact-form">
    <div class="container">
        <h2>Learn More...</h2>
        <div class="row">
            <div class="col">
                <label for="first-name">First Name</label>
                [text* first-name id:first-name]
            </div>
            <div class="col">
                <label for="last-name">Last Name<span>*</span></label>
                [text* last-name id:last-name]
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="email">Email Address</label>
                [email* email id:email]
            </div>
            <div class="col">
                <label for="phone-number">Phone Number</label>
                [tel phone-number id:phone-number]
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="business-name">Business Name</label>
                [text business-name id:business-name]
            </div>
            <div class="col">
                <label for="business-website">Business Website</label>
                [url business-website id:business-website]
            </div>
        </div>
        <div class="row-group">
            <div class="col full-width">
                <label for="further-information">Further Information</label>
                [textarea further-information id:further-information]
            </div>
        </div>
        <div class="row">
            [submit "Submit"]
        </div>
    </div>
</div>