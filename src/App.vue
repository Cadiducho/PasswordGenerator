<template>
    <div id="app">
        <vue-headful
                title="Generador de contraseñas | Cadiducho.com"
                description="Generador de contraseñas"
        />
        <h1>Generador de contraseñas</h1>

        <h3>
            <span v-if="!darkMode" @click="changeTheme()" class="pointer noselect">Cambiar a modo oscuro 🌑</span>
            <span v-else @click="changeTheme()" class="pointer noselect">Cambiar a modo claro ☀️ </span>
        </h3>

        <fieldset>
            <legend>Características</legend>
            <p>
                <input type="checkbox" id="numbers" v-model="numbers" @change="generate()">
                <label for="numbers" v-if="numbers">Números incluídos</label>
                <label for="numbers" v-else class="red">No incluir números</label>
            </p>
            <p>
                <input type="checkbox" id="mayus" v-model="mayus" @change="generate()">
                <label for="mayus" v-if="mayus">Mayúsculas incluídas</label>
                <label for="mayus" v-else class="red">No incluir mayusculas</label>
            </p>
            <p>
                <input type="checkbox" id="minus" v-model="minus" @change="generate()">
                <label for="minus" v-if="minus">Minúsculas incluídas</label>
                <label for="minus" v-else class="red">No incluir minúsculas</label>
            </p>
            <p>
                <input type="checkbox" id="symbols" v-model="symbols" @change="generate()">
                <label for="symbols" v-if="symbols">Símbolos y caracteres especiales incluídos</label>
                <label for="symbols" v-else class="red">No incluir símbolos o caracteres especiales</label>
            </p>
            <hr>
            <p>
                <label for="size">Número de caracteres</label>
                <input type="number" min="1" id="size" v-model="size" @change="generate()">
            </p>
            <p>
                <label for="size">Caracteres a evitar</label>
                <input type="text" id="avoid" v-model="avoid" placeholder="Ejemplo: i l I |" @change="generate()">
            </p>
            <p>
                <input type="checkbox" id="hidden" v-model="hidden" @change="generate()">
                <label for="hidden" v-if="hidden">Ocultar la contraseña generada</label>
                <label for="hidden" v-else>No ocultar la contraseña generada</label>
            </p>
        </fieldset>
        <section>
            <div class='row'>
                <div class="column">
                    <input id="generated" :type="hidden ? 'password' : 'text'" readonly :value="password">
                </div>
                <div class='column-4'>
                    <button v-clipboard:copy="password" v-clipboard:success="onCopy" :disabled="copy.copied">
                        {{copy.texto}}
                    </button>
                </div>
            </div>
            <button type="button" @click="generate()">Generar otra</button>
        </section>

        <section>
            <h2>Acerca de</h2>
            Ninguna contraseña es guardada. Toda la generación ocurre en tu navegador.
            <br>
            Creado con <a href="https://vuejs.org/">Vue.js</a> y una version modificada de <a href="https://github.com/kognise/water.css">Water.css</a>
        </section>


        <footer>
            Este generador de contraseñas es gratuito y de <a href="https://github.com/Cadiducho/PasswordGenerator">código abierto</a>. Desarrollado por <a href="https://twitter/Cadiducho">@Cadiducho</a> y <a href="https://github.com/Cadiducho/PasswordGenerator/graphs/contributors">colaboradores</a> | <a href="https://cadiducho.com">Cadiducho.com</a>
        </footer>
    </div>
</template>

<script>
    export default {
        name: 'PasswordGenerator',
        data: function () {
            return {
                password: this.value,

                numbers: true,
                minus: true,
                mayus: true,
                symbols: true,
                size: 8,
                hidden: false,
                avoid: '',

                copy: {
                    texto: '🔖 ¡Copiar!',
                    copied: false,
                },

                characters: {
                    type: String,
                    default: 'a-z,A-Z,0-9,#'
                },

                darkMode: false,
            }
        },
        mounted: function () {
            this.generate();

            // Themes
            let htmlElement = document.documentElement;
            let theme = localStorage.getItem("theme");

            if (theme === 'dark') {
                htmlElement.setAttribute('theme', 'dark')
                this.darkMode = true
            } else {
                htmlElement.setAttribute('theme', 'light');
                this.darkMode = false
            }
        },
        methods: {
            generate() {
                this.copy.copied = false;
                this.copy.texto = '🔖 ¡Copiar!';

                let characterList = '';
                let password = '';

                if (this.minus) {
                    characterList += 'abcdefghijklmnopqrstuvwxyz';
                }
                if (this.mayus) {
                    characterList += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                }
                if (this.numbers) {
                    characterList += '0123456789';
                }
                if (this.symbols) {
                    characterList += '![]{}()%&*$#^<>~@|';
                }
                if (this.avoid) {
                    let i = this.avoid.length;
                    while (i--) {
                        let char = this.avoid.charAt(i);
                        characterList = characterList.replace(char, "");
                    }
                }

                const randomArray = window.crypto.getRandomValues(new Uint32Array(this.size))
                for (const number of randomArray) {
                    password += characterList.charAt(number % characterList.length);
                }
                this.password = password;
            },
            changeTheme() {
                this.darkMode = !this.darkMode;
            },
            onCopy() {
                this.copy.texto='✔️ Copiado';
                this.copy.copied = true;
            }
        },
        watch: {
            darkMode: function () {
                // add/remove class to/from html tag
                let htmlElement = document.documentElement;

                if (this.darkMode) {
                    localStorage.setItem("theme", 'dark');
                    htmlElement.setAttribute('theme', 'dark');
                } else {
                    localStorage.setItem("theme", 'light');
                    htmlElement.setAttribute('theme', 'light');
                }
            }
        }
    }
</script>

<style>
    @import './assets/css/flex.css';
    @import './assets/css/light.css';
    @import "./assets/css/theme-colors.css";

    input {
        margin-right: 5px!important;
    }
    .red {
        color: orangered;
    }
    .pointer {
        cursor: pointer;
    }
    .noselect, span, label {
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
    }
</style>
