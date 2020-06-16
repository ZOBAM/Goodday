<template>
    <div class="container-fluid">
            <div class="row">
                <div class = 'col-sm-3' id="left-nav">
                   <nav class="nav flex-column" v-for="(value, name, index) in info" :key="value.index">
                        <a class="" href="" @click.prevent="moveNow(name)">{{ index }}. {{ name }}: {{ value }}</a>
                        <!-- <a class="nav-link active" href="#">Manage Customers</a> -->
                    </nav>
                    <div class="alert">
                        <p>Ensure that you keep your password safe, secure and personal</p>
                    </div>
                </div>
                <div class="col-sm-9" id="main-content">
                    <div class="card">
                        <div class="card-header" v-bind:title="actionTitle">{{actionTitle}}</div>

                        <div class="card-body">
                            <component v-bind:is="currentTab" class="tab"></component>
                            <p v-if="currentTab == 'tab-home'">{{welcomeMsg}}</p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
import NavComponent from '../components/NavComponent';
    export default {
        data:function(){
            return {
                firstName: 'Glory',
                currentCustomer : null,
                actionTitle : 'Customer\'s',
                currentTab : 'tab-home',
                welcomeMsg : '',
                info:null,
                currentLocation: location.pathname,
                section : '',
                savingsLinks : ['Create Saving','Add Collection','Disburse','Close Saving'],
                customersLinks : ['Create Account','Update Account','View Account'],
                loansLinks : ['New Loan','Pending Loans','Approved Loans','Loan Repayment'],
                transactionsLinks : ['Today','This Week','This Month'],
                staffsLinks : ['Add Staff','Remove Staff'],
          }
        },
        components:{
            NavComponent,
        },
        methods: {
            greet : function(){
                alert("Hail Christ!");
            },
            moveNow: function(index){
                if(this.section == 'savings'){
                    switch(index){
                        case 0:
                            this.currentTab = 'savings-create';
                            break;
                        case 1:
                            this.currentTab = 'savings-collection';
                            break;
                        case 2:
                            this.currentTab = 'savings-disburse';
                            break;
                        case 3:
                            this.currentTab = 'savings-close';
                            break;
                    }//end switch
                }//end if
                else if(this.section == 'customers'){
                    switch(index){
                        case 0:
                            this.currentTab = 'create-account';
                            break;
                        case 1:
                            this.currentTab = 'update-account';
                            break;
                        case 2:
                            this.currentTab = 'view-account';
                            break;
                    }//end switch
                }
                else if(this.section == 'loans'){
                    switch(index){
                        case 0:
                            this.currentTab = 'new-loan';
                            break;
                        case 1:
                            this.currentTab = 'pending-loans';
                            break;
                        case 2:
                            this.currentTab = 'approved-loans';
                            break;
                        case 3:
                            this.currentTab = 'loan-repayment';
                            break;
                    }//end switch
                }
                else if(this.section == 'transactions'){
                    switch(index){
                        case 0:
                            this.currentTab = 'day';
                            break;
                        case 1:
                            this.currentTab = 'week';
                            break;
                        case 2:
                            this.currentTab = 'month';
                            break;
                    }//end switch
                }
                //this.currentTab = 'tab-save';
                //alert(index)
        }
        },
        computed:{
            getSection: function(){
            let sectionArr = this.currentLocation.split('/');
            return sectionArr[1];
            },
            currentTabComponent: function() {
            return "tab-home";
          }
        },
        mounted() {
            this.section = this.getSection;
            switch(this.section){
                case'savings':
                    this.info = this.savingsLinks;
                    this.actionTitle += " Savings";
                    this.welcomeMsg = "Welcome, here you can carry out operations related to customers Savings";
                    break;
                case 'loans':
                    this.info = this.loansLinks;
                    this.actionTitle += " Loans"
                    this.welcomeMsg = "Welcome, here you can carry out operations related to customers Loans";
                    break;
                case 'customers':
                    this.info = this.customersLinks;
                    this.actionTitle += " Services"
                    this.welcomeMsg = "Welcome, here you can carry out operations related to customers account";
                    break;
                case 'transactions':
                    this.info = this.transactionsLinks;
                    this.actionTitle = "Record of Transactions"
                    break;
            }
            //alert(this.name);
            //console.log('Component mounted.')
        }
    }
</script>
