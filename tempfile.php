pw1: {
                        required: true,
                        maxlength: 20,
                        minlength: 4,
                    },
                    pw2: {
                        required: true,
                        equalTo: '#pw1'
                    },
                    cname: {
                        required: true
                    },
                    tssn: {
                        required: true,
                        tssn: true
                    },
                    birthday: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                        checkphone: true,
                    },
                    recaptcha: {
                        required: true,
                        equalTo: '#captcha',
                        captcha: true
                    }

                    