<template>
    <div class="container py-5">
        <div class="card rounded shadow">
            <div class="card-header">
                <h2>Employee List</h2>
                <router-link :to="{ name: 'employee.create' }" class="btn btn-primary">Add Employee</router-link>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Address</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(employee, index) in employees.data" :key="index">
                            <td>{{ employee.id }}</td>
                            <td>{{ employee.name }}</td>
                            <td>{{ employee.email }}</td>
                            <td>{{ employee.gender }}</td>
                            <td>{{ employee.address }}</td>
                            <td>
                                <div class="btn-group gap-2">
                                    <router-link :to="{ name: 'employee.edit', params: { id: employee.id } }"
                                        class="btn btn-sm btn-success">Edit</router-link>
                                    <button @click.prevent="destroy(employee.id, index)"
                                        class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { useRouter } from 'vue-router'
import { onMounted, ref } from 'vue'

export default {
    setup() {
        // Reactive state
        let employees = ref([])

        const router = useRouter()

        onMounted(async () => {
            getEmployees()
        })

        const getEmployees = () => {
            // Get data from API endpoint
            axios.get('http://localhost:8000/api/v1/employees')
                .then((result) => {
                    employees.value = result.data
                    // console.log(result.data.data);
                }).catch((err) => {
                    console.log(err.response.message)
                })
        }

        const destroy = (id, index) => {
            if (confirm('Are you sure want to delete this data?')) {
                axios.delete(
                    `http://localhost:8000/api/v1/employees/${id}`)
                    .then((res) => {
                        employees.value.data.splice(index, 1)
                        alert(res.data.message)
                    }).catch((err) => {
                        console.log(err.response.data)
                    });
            }
        }

        return {
            employees,
            router,
            destroy
        }
    }
}
</script>