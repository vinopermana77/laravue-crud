<template>
    <div class="container py-5">
        <div class="card rounded shadow">
            <div class="card-header d-flex align-items-center">
                <h2>Create Employee</h2>
            </div>
            <div class="card-body">
                <form @submit.prevent="store()">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" v-model="employee.name">
                        <div v-if="validation.name" class="mt-2 alert alert-danger">
                            {{ validation.name[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" v-model="employee.email">
                        <div v-if="validation.email" class="mt-2 alert alert-danger">
                            {{ validation.email[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select" v-model="employee.gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div v-if="validation.gender" class="mt-2 alert alert-danger">
                            {{ validation.gender[0] }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="address" style="height: 100px"
                            v-model="employee.address"></textarea>
                        <div v-if="validation.address" class="mt-2 alert alert-danger">
                            {{ validation.address[0] }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <router-link :to="{ name: 'employee.index' }"
                        class="float-end text-white btn btn-info">Back</router-link>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
    setup() {
        // Data binding
        const employee = reactive({
            name: '',
            email: '',
            gender: '',
            address: '',
        })

        const validation = ref([])

        const router = useRouter()

        const store = () => {
            axios.post(
                'http://localhost:8000/api/v1/employees',
                employee
            ).then((res) => {
                router.push({
                    name: 'employee.index'
                })
                alert(res.data.message)
            }).catch((err) => {
                validation.value = err.response.data
            });
        }

        return {
            employee,
            validation,
            router,
            store
        }
    }
}
</script>
