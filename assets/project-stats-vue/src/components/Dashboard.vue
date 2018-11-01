<template>
    <section class="section">
        <div class="container">
            <nav class="navbar" role="navigation" aria-label="main navigation">
                <div class="navbar-menu is-active buttons">
                    <router-link to="/" tag="button" id='home-button' class="button is-link"> Home</router-link>
                    <router-link to="/project/list" tag="button" id='projects-button' class="button is-link"> Projects</router-link>
                </div>
            </nav>
            <router-view></router-view>
        </div>
    </section>
</template>

<script>
    export default {
        data: function () {
            return {
                authenticated: false
            }
        },
        methods: {

        }
    }
</script>