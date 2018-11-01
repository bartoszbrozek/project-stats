<template>
    <div>
        <span class="help is-info" v-if="isLoading">Loading...</span>
        <table class="table" v-else>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Directory</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(project, index) in projects">
                <tr v-bind:key="project.id">
                    <td>{{ project.id }}</td>
                    <td>{{ project.name }}</td>
                    <td>{{ project.directory }}</td>
                    <td>{{ project.created_at }}</td>
                    <td>
                        <button class="button is-primary" @click="removeProject(project.id, index)">
                            Test
                        </button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
        <project-form @completed="addProject"></project-form>
    </div>

</template>

<script>
    import axios from 'axios'
    import ProjectForm from './ProjectForm.vue'
    import consts from '../consts.js'

    export default {
        components: {
            ProjectForm
        },
        data() {
            return {
                projects: {},
                isLoading: true,
                countUpdatingTable: []
            }
        },
        async created() {
            try {
                const response = await axios.get(consts.SERVER + "project/list")
                this.projects = response.data
                this.isLoading = false
            } catch (e) {

            }
        },
        methods: {
            addProject(project) {
                this.projects.push(project.object)
            },
            async removeProject(id, index) {
                axios.delete(consts.SERVER + "project/" + id + "/remove",
                ).then(response => {
                    this.isLoading = false
                    this.projects.splice(index, 1)
                }).catch(e => {
                    this.errors = e.toString()
                })
            }
        }
    }
</script>
