<template>
    <div class="container-fluid">
        <nav class="nav flex-column" v-for="(value, name, index) in info" :key="value.index">
            <a class="" href="" @click="moveNow(name)">{{ index }}. {{ name }}: {{ value }}</a>
            <!-- <a class="nav-link active" href="#">Manage Customers</a> -->
        </nav>
        <div class="alert">
            <p>Ensure that you keep your password safe, secure and personal</p>
        </div>
        <!-- <button @click="showInfo">Click Me {{section}}</button> -->
        <!-- <ul v-for="(value, name, index) in info" :key="value.index">
            <li>{{ index }}. {{ name }}: {{ value }}</li>
        </ul> -->
    </div>
</template>
<script>
    //FOR SAVINGS
Vue.component("savings-create", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>creating saving record! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("savings-collection", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Collecting cash! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("savings-disburse", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Giving out some cash! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("savings-close", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>This cycle is complete! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
      //FOR CUSTOMERS
Vue.component("create-account", {
    data: function(){
        return {
            nickname : 'Zubby',
            customer : null,
            }
        },
        methods: {
            updateCustomer: function(customerObj){
                this.customer = customerObj;
                alert(this.customer);
            },
            formPost: function(e){
                const form = e.target;
                const formData = new FormData(form) ;// get all named inputs in form
                /* for (const [inputName, value] of formData) {
                    console.log( value )
                } */
                var _this = this;
                axios.post('http://www.gday.net/customers', formData)
                .then(function (response) {
                    console.log(response.data);
                    _this.updateCustomer(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        props : ['currentCustomer'],
        template: `<div>{{firstName}}
            <div class="row">
                <div class="col-md-12" v-if='!customer'>
                    <form method="POST"  enctype="multipart/form-data" id='post-ad-form' @submit.prevent = "formPost($event)">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="title">First Name:</label>
                                    <input type="text" class="form-control" placeholder="First Name" v-model ='firstName' name="first_name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="surname">Surname:</label>
                                    <input type="text" class="form-control" placeholder="Surname" id="surname" name="surname" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="other_name">Other Name:</label>
                                    <input type="text" class="form-control" placeholder="Other Name" id="other_name" name="other_name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="phone_number">Phone No.:</label>
                                    <input type="text" class="form-control" placeholder="Surname" id="phone_number" name="phone_number" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="next_of_kin">Next of Kin:</label>
                                    <input type="text" class="form-control" placeholder="Next of Kin" id="next_of_kin" name="next_of_kin" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="nok_relationship">Relationship:</label>
                                    <select class="form-control" id="nok_relationship" name="nok_relationship" required>
                                        <option value="father">Father</option>
                                        <option value="husband">Husband</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="state">State:</label>
                                    <input type="text" class="form-control" placeholder="State" id="state" name="state" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="lga">LGA:</label>
                                    <select class="form-control" id="lga" name="lga" required>
                                        <option value="father">Father</option>
                                        <option value="husband">Husband</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="community">Community:</label>
                                    <input type="text" class="form-control" placeholder="Community" id="community" name="community" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="full_address">Full Address:</label>
                                    <input type="text" class="form-control" placeholder="Full Address" id="full_address" name="full_address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Email (optional):</label>
                                    <input type="email" class="form-control" placeholder="email" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="poverty_index">Poverty Index:</label>
                                    <input type="text" class="form-control" placeholder="Poverty Index" id="poverty_index" name="poverty_index" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <select class="form-control" required id="gender" name="gender">
                                    <option value="">--Select Category--</option>
                                    @foreach($categories as $category => $subcategories)
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-*-*">
                                <button type="submit" class="btn btn-primary" id="submit-ad">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12" v-if='customer'>
                    <p> Customer account has been created!</p>
                    <p> {{currentCustomer}}</p>
                </div>
            </div>
        </div>`
      });
Vue.component("update-account", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Udpdating account! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("view-account", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Viewing account! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
      //FOR LOANS
Vue.component("new-loan", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>About to give out loan! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("pending-loans", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Loan on the waiting list! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("approved-loans", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Business boosted by fire! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("loan-repayment", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Return time! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
      // FOR TRANSACTIONS
Vue.component("day", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>Today's deals! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("week", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>This week! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });
Vue.component("month", {
    data: function(){
        return {nickname : 'Zubby'}
        },
        props : ['name'],
        template: `<div>This month! <hr> nickname: {{nickname}}
                        <input type="text" v-model="nickname"></div>`
      });

/* export default {
    mounted: function(){
       //axios.get('http://www.gday.net/customers')      .then(response => (this.info = response.data));
      //alert(this.info)
    }
} */
</script>
