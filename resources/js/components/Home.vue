<template>
    <div class="container-fluid m-5">
        <div class="row">
            <div class="col-9 form-section">
                <h4 class="mb-3">List of submissions</h4>
                <div class="search-bar">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" v-model="entryDate" placeholder="Search by Entry Date"
                                class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <button @click="search" class="btn btn-primary">Search</button>
                        </div>

                    </div>

                </div>
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Buyer</th>
                            <th scope="col">Receipt Id</th>
                            <th scope="col">items</th>
                            <th scope="col">BuyerEmail</th>
                            <th scope="col">Buyer Ip</th>
                            <th scope="col">City</th>
                            <th scope="col">Phone</th>
                            <th scope="col">EntryAt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="value in submissions_list">
                            <!-- {{ submissions_list }} -->
                            <th scope="row">{{ value.id }}</th>
                            <td>{{ value.amount }}</td>
                            <td>{{ value.buyer }}</td>
                            <td>{{ value.receipt_id }}</td>
                            <td>{{ value.items }}</td>
                            <td>{{ value.buyer_email }}</td>
                            <td>{{ value.buyer_ip }}</td>
                            <td>{{ value.city }}</td>
                            <td>{{ value.phone }}</td>
                            <td>{{ value.entry_at }}</td>
                            <td>
                                <!-- <span class="mr-2">
                                    <font-awesome-icon icon="trash-alt" :style="{ color: 'red' }" />
                                </span>
                                <span>
                                    <font-awesome-icon :icon="['fas', 'user-edit']" />
                                </span> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="pagination">
                    <button @click="prevPage" :disabled="currentPage === 1">Previous</button>
                    <span>Page {{ currentPage }} of {{ totalPages }}</span>
                    <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
                </div>
            </div>
            <div class="col-3">
                <Form @submit="saveData()">
                    <div class="form-row form-section">
                        <h4 class="mb-3">Add Submission Info</h4>

                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="amount">Amount
                                <span class="form-required">*</span>
                            </label>
                            <Field name="amount" type="number" class="form-control" v-model="submissions.amount"
                                :rules="isRequired" placeholder="Amount" />

                            <ErrorMessage class="form-required" name="amount" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="Buyer">Buyer
                                <span class="form-required">*</span>
                            </label>
                            <Field name="buyer" type="text" class="form-control" v-model="submissions.buyer"
                                :rules="isRequired" placeholder="Buyer" />
                            <ErrorMessage class="form-required" name="buyer" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="Receipt id">Receipt id
                                <span class="form-required">*</span></label>
                            <Field name="receipt_id" type="text" class="form-control" v-model="submissions.receipt_id"
                                :rules="isRequired" placeholder="Receipt id" />
                            <ErrorMessage class="form-required" name="receipt_id" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="items">items
                                <span class="form-required">*</span></label>
                            <Field name="items" type="text" class="form-control" v-model="submissions.items"
                                :rules="isRequired" placeholder="items" />
                            <ErrorMessage class="form-required" name="items" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="email">Buyer Email
                                <span class="form-required">*</span></label>
                            <Field name="buyer_email" type="email" class="form-control" v-model="submissions.buyer_email"
                                :rules="validateEmail" placeholder="Email" />
                            <ErrorMessage class="form-required" name="buyer_email" />
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="note">Note</label>
                            <Field name="note" type="text" class="form-control" v-model="submissions.note"
                                :rules="isRequired" placeholder="Note" />
                            <ErrorMessage class="form-required" name="note" />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="city">City</label>
                            <Field name="city" type="text" class="form-control" v-model="submissions.city"
                                :rules="isRequired" placeholder="City" />
                            <ErrorMessage class="form-required" name="city" />
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label form-label-top" for="Phone">Phone
                                <span class="form-required">*</span>
                            </label>
                            <Field name="phone" type="number" class="form-control" v-model="submissions.phone"
                                :rules="isRequired" placeholder="Phone" />
                            <ErrorMessage class="form-required" name="phone" />
                        </div>

                        <button class="btn btn-primary" type="submit">
                            SUBMIT
                        </button>
                    </div>
                </Form>


            </div>
        </div>
    </div>
</template>
<script >
import { Form, Field, ErrorMessage } from 'vee-validate';
import VueCookies  from 'vue-cookies';
const COOKIE_NAME = 'submission_limit';
const COOKIE_EXPIRATION_DAYS = 1;
export default {

    components: {
        Form,
        Field,
        ErrorMessage
    },

    data() {
        return {
            submissions: {
                'amount': '',
                'buyer': '',
                'receipt_id': '',
                'items': '',
                'buyer_email': '',
                'note': '',
                'city': '',
                'phone': '',
            },
            submissions_list: [],
            currentPage: 1,
            pageSize: 10,
            totalItems: 0,
            entryDate: '',
        };
    },
    plugins: [VueCookies],

    mounted() {
        // axios.get('/submission').then(
        //     (response) => {
        //         // console.log(response.data);
        //         this.submissions_list = response.data;


        //     }).catch(error => {
        //         console.log(error);
        //     });
        this.fetchSubmissions();

    },

    methods: {
        isRequired(value) {
            if (value && value.trim()) {
                return true;
            }
            return 'This is required';
        },
        validateEmail(value) {
            // if the field is empty
            if (!value) {
                return 'This field is required';
            }
            // if the field is not a valid email
            const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if (!regex.test(value)) {
                return 'This field must be a valid email';
            }
            // All is good
            return true;
        },

        fetchSubmissions() {
            axios.get('/submission', {
                params: {
                    page: this.currentPage,
                    pageSize: this.pageSize,
                    entryDate: this.entryDate,
                },
            }).then((response) => {
                this.submissions_list = response.data.data;
                this.totalItems = response.data.total;
            })
                .catch((error) => {
                    console.log(error);
                });
        },

        checkSubmissionLimit() {
            const submissionLimit = this.$cookies.get(COOKIE_NAME);
            if (submissionLimit) {
                const now = Date.now();
                const lastSubmissionTime = parseInt(submissionLimit, 10);
                const twentyFourHours = 24 * 60 * 60 * 1000; // 24 hours in milliseconds
                if (now - lastSubmissionTime < twentyFourHours) {
                    // User has already submitted within the last 24 hours
                    return false;
                }
            }
            return true;
        },



        saveData() {
            // console.log(this.submissions);
            // e.preventDefault();

            if (!this.checkSubmissionLimit()) {
                // User has reached the submission limit
                this.$toast.error('You can only submit once within 24 hours.', {
                    position: 'top-right',
                });
                return;
            }

            axios.post('/submission', this.submissions).then(
                response => {
                    var jsonData = response.data;
                    this.submissions_list.push(response.data.data)
                    this.$toast.success(jsonData.message, {
                        position:
                            "top-right",

                    });
                    this.submissions = {
                        'amount': '',
                        'buyer': '',
                        'receipt_id': '',
                        'items': '',
                        'buyer_email': '',
                        'note': '',
                        'city': '',
                        'phone': '',
                    }

                }
            ).catch(error => {
                this.$toast.error(error.response.data.message, {
                    position:
                        "top-right",
                });
            });
            const now = Date.now();
            this.$cookies.set(COOKIE_NAME, now.toString(), {
                expires: new Date(Date.now() + COOKIE_EXPIRATION_DAYS * 24 * 60 * 60 * 1000), 
            });
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchSubmissions();
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchSubmissions();
            }
        },

        search() {
            this.currentPage = 1;
            this.fetchSubmissions();
        },


    },
    computed: {
        totalPages() {
            return Math.ceil(this.totalItems / this.pageSize);
        },
    },


};


</script>
<style scope>
.form-label-top {
    width: 100%;
    margin-left: 2px;
    margin-bottom: 10px;
}

.form-label {
    color: #2c3345;
    display: inline-block;
    font-size: 16px;
    font-weight: 500;
    word-break: break-word;
}

.form-required {
    color: #f23a3c;
}

.form-section {
    border-radius: 10px;
    overflow: hidden;
    padding: 62px 55px 65px;
    box-shadow: 0 3px 20px 0 rgb(0 0 0 / 10%);
    -moz-box-shadow: 0 3px 20px 0 rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0 3px 20px 0 rgb(0 0 0 / 10%);
    -o-box-shadow: 0 3px 20px 0 rgba(0, 0, 0, 0.1);
    -ms-box-shadow: 0 3px 20px 0 rgba(0, 0, 0, 0.1);
}

Field.form-control {
    height: 44px;
}

tbody,
td,
tfoot,
th,
thead,
tr {
    line-height: 48px;
}

.mr-2 {
    margin-right: 10px;
}
</style>



