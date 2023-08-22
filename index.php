<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
     
</head>
<body>
  <!--
        CONTACT US FORM HTML
 
BACK END PHP CODE AND MYSQL DATABASE CODE

        SOURCE : // 
https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046
    -->
    <article class="fullScreen80Flex contactForm ">
        <div class="formContainer">
            <div class="heading ">
                <h1>CONTACT US</h1>
            </div>

            <div id="contact-us" class="form ">
                <form action="form.php" method="POST">
                    <label for="name">Name</label>
                    <p data-error="name" class="errors"></p>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <label for="email">Email</label>
                    <p data-error="email" class="errors"></p>
                <input type="email" name="email" id="email" class="form-control" required>
                    
                    
                    <label for="message">Message</label>
                    <p data-error="message" class="errors"></p>
                <input type="text" name="message" id="message" class="form-control" required>
                    <div id="status">
                    </div>
                    <button type="submit ">SEND</button>
                </form>

            </div>
            <a style="display:none !important;" href="https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046">SOURCE</a>
        </div>
    </article>
    </div>
    </div>
        </form> 
    </div>
</article>

</body>
<script >
     /*
 
BACK END PHP CODE AND MYSQL DATABASE CODE


https://www.thewebblinders.in/programming/article/responsive-html-contact-us-form-php-mysql-with-validations-6046


 */  


        class ContactUs {
            constructor() {

                this.formEle = document.getElementById("contactForm");
                this.statusEle = document.getElementById("status");

                this.nameEle = document.getElementById("name");
                this.emailEle = document.getElementById("email");
                this.messageEle = document.getElementById("message");
            }



            init() {

                this.formEle.onsubmit = (e) => {
                    e.preventDefault();
                    this.clearErrors();
                    this.validate();
                }

            }

            validate() {
                var hasErrors = false;

                if (this.isEmpty(this.nameEle, true) || this.isInvalidLength(this.nameEle.value, [3, 60])) {

                    this.displayError('name', "* Name must be between 3 to 60 characters");
                    hasErrors = true;
                }


                if (this.isEmpty(this.emailEle, true) || !this.isValidEmail(this.emailEle.value)) {
                    this.displayError('email', "* Enter valid email");
                    hasErrors = true;
                }

                if (this.isEmpty(this.messageEle, true) || this.isInvalidLength(this.messageEle.value, [3, 1024])) {

                    this.displayError('message', "* Message must be between 3 to 1024 characters");
                    hasErrors = true;
                }

                if (hasErrors) {
                    return;
                }

                /*
                console.log({
                    email: this.emailEle.value,
                    mobile: this.mobileEle.value,
                    address: this.addressEle.value,
                    name: this.nameEle.value
                });
                */
                this.statusEle.classList.add("active");
                this.statusEle.innerHTML = `<p>Please Wait....</p>`;


                this.ajaxData(JSON.stringify({
                    email: this.emailEle.value,
                    message: this.messageEle.value,
                    name: this.nameEle.value
                }));



            }

            displayError(dataError, message) {
                try {
                    document.querySelector(`p[data-error=${dataError}]`).innerHTML = message;

                } catch (e) {
                    console.log(e);
                }
            }

            clearErrors() {
                this.statusEle.classList.remove("active");
                this.statusEle.innerHTML = "";
                document.querySelectorAll(`p.errors`).forEach((ele) => {
                    ele.innerHTML = "";
                });
            }



            ajaxData(jsonData) {
                const url = './process-contact-us.php';
                let xhttp = new XMLHttpRequest();
                let that = this;
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {

                        try {
                            let data = JSON.parse(this.responseText);
                            if (data['status'].toString().toLowerCase() == 'true') {
                                that.formEle.reset();
                                that.statusEle.classList.add("active");
                                that.statusEle.innerHTML = `<p>Thank you , we will get back to you</p>`;
                                setTimeout(() => {
                                    that.statusEle.classList.remove("active");
                                    that.statusEle.innerHTML = "";
                                }, 3000);
                            } else {
                                that.statusEle.innerHTML = `<p>Server error or Invalid data supplied</p>`;
                            }
                        } catch (err) {
                            console.log(err);
                            that.statusEle.innerHTML = `<p>Something went wrong, try again</p>`;

                        }
                    }
                };
                xhttp.open("POST", url, true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(`data=${jsonData}`);
            }


            isEmpty(ele, isElement = true) {
                try {
                    console.log(ele);
                    if (isElement) {
                        if (ele.value == "" || ele.value == null || ele.value.replace(/ /g, "").length == 0) {
                            return true;
                        }
                        ele.value = this.htmlspecialchars(ele.value.trim());
                        return false;
                    } else {
                        if (ele == "" || ele == null || ele.replace(/ /g, "").length == 0) {
                            return true;
                        }
                        return false;
                    }

                } catch (err) {
                    console.log(err);
                    return true;
                }
            }
            isInvalidLength(input, rangeArray) {
                try {
                    let len = input.toString().length;
                    return (len < rangeArray[0] || len > rangeArray[1]);
                } catch (e) {
                    console.log(e);
                    return true;
                }
            }
            isValidEmail(email) {
                let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
            htmlspecialchars(string) {
                var specialchars = [
                    ['&', '&amp;'],
                    ['<', '&lt;'],
                    ['>', '&gt;'],
                    ['"', '&quot;']
                ];
                var escapedString = string;
                var len = specialchars.length;
                for (var x = 0; x < len; x++) {
                    escapedString = escapedString.replace(
                        new RegExp(specialchars[x][0], 'g'),
                        specialchars[x][1]
                    );
                }
                // Return the escaped string.
                return escapedString;
            }

        }

        var contactUs = new ContactUs();
        contactUs.init(); 
</script>
</html>