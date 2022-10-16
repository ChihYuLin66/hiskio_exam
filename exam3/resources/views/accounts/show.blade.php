@extends('layouts.app')

@section('content')
<div id="account_dashboard" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">帳戶</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <button 
                                type="button" 
                                class="btn btn-success mr-2"
                                data-toggle="modal" 
                                data-target="#setAmountModal" 
                                @click="method='increase'" 
                            >存錢</button>

                            <button 
                                type="button" 
                                class="btn btn-danger mr-2"
                                data-toggle="modal" 
                                data-target="#setAmountModal" 
                                @click="method='decrease'" 
                            >提款</button>


                            <a href="{{ Route('home') }}">
                                <button 
                                    type="button" 
                                    class="btn btn-light  float-right"

                                >返回</button>
                            </a>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right">金額</th>
                                        <th class="text-right">存款金額</th>
                                        <th class="text-center">日期</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, index) in records">
                                        <td class="text-right">$ @{{ record.amount }}</td>
                                        <td class="text-right">$ @{{ record.balance }}</td>
                                        <td class="text-center">@{{ record.created_at }}</td>                                        
                                    </tr>

                                    <tr v-if="!records.length">
                                        <td colspan="3" class="text-center">
                                            無資料
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="setAmountModal" tabindex="-1" role="dialog" aria-labelledby="setAmountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  v-if="method === 'increase'">存錢</h5>
                    <h5 class="modal-title"  v-else-if="method === 'decrease'">提款</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <span v-if="method === 'increase'"> + </span>
                    <span v-else-if="method === 'decrease'"> - </span>
                    
                    <input type="number" v-model="amount" min="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="storeAccount">送出</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
import { createApp } from 'https://cdnjs.cloudflare.com/ajax/libs/vue/3.2.37/vue.esm-browser.min.js'
import { default as axios } from 'https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/esm/axios.min.js'



const app = createApp({
    data() {
        return {
            method: 'increase',
            amount: 1,
            records: [],
        }
    },
    methods: {
        
        getAccounts() {
            axios.get('{{ route("api.user.accounts.index") }}', {
            
            }).then((response) => {
                if (response.data.status !== true) {
                    return alert(response.data.message);
                }

                this.records = response.data.data.records;
            })
        },
        storeAccount() {
            
            axios.post('{{ route("api.user.accounts.store") }}', {
                amount : this.method == 'increase' ? Math.abs(this.amount) : Math.abs(this.amount) * -1
            }).then((response) => {
                this.amount = 1;
                
                if (response.data.status !== true) {
                    return alert(response.data.message);
                }
                alert(response.data.message);
                this.getAccounts();
            })
        },

    },
    mounted() {
        this.getAccounts();
    }
});


app.mount('#account_dashboard');

</script>
@endsection
