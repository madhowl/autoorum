let app = new Vue({
    delimiters: ['${', '}'],
    el: '#app',

    data:{
      isFullLoading:true,
      isLoading: true, // Добавлена переменная состояния для загрузки запросов
      pages: {
          page:1,
          sub_page:1,
          sub2_page:1
      },
      companies: [],
      models: [],
      years: [],
      configurations: [],
      findCar:{
          mark:{id:'',name:''},
          model:{id:'',name:''},
          car:{id:'',year:'',image:'',price_min:'',price_max:''},
          configuration:{id:'',name:''}

      },
      configurationsMore:[],
      userData:{
          FIO:'',
          email:'',
          tell:'',
          type_call:'tell', //tell, Whatsapp, Telegram
          info:''
      },
      selectHaggler:'Japan Trade_1',
        
        
    },
    created:function (){
        
    },

    computed: {

    },

    methods:{
        goToHome(){
            if(this.pages.page===3){
                this.pages.sub_page=2;
            }
            this.pages.page=1;
        },
        scrollToApp() {
            const contactElement = document.getElementById('head');
            if (contactElement) {
                contactElement.scrollIntoView({ behavior: 'smooth' });
            }
        },
        clickSelectCar() {
            this.pages.sub_page=2;
            this.$nextTick(() => {
                const contactElement = document.getElementById('selectCar');
                if (contactElement) {
                  contactElement.scrollIntoView({ behavior: 'smooth' });
                } else {
                  console.error("Element with id 'selectCar' not found.");
                }
              });
            this.configurationsMore = this.findCar.configuration.name.split(/,\s*/).map(item => item.trim());
            if (!isNaN(this.findCar.car.price_min)){
              this.findCar.car.price_min = Number(this.findCar.car.price_min);
              this.findCar.car.price_min = this.findCar.car.price_min.toLocaleString('ru-RU').replace(/\s/g, '&nbsp;');
            }
            if (!isNaN(this.findCar.car.price_max)){
              this.findCar.car.price_max = Number(this.findCar.car.price_max);
              this.findCar.car.price_max = this.findCar.car.price_max.toLocaleString('ru-RU').replace(/\s/g, '&nbsp;');
            }
            
        },
        clickSelectEnd() {
            this.pages.page=3;
            this.pages.sub_page=1;
            this.scrollToApp();
        },
        nextButton(){
            this.pages.sub_page=2;
            this.$nextTick(() => {
                const contactElement = document.getElementById('hagglers_find');
                if (contactElement) {
                  contactElement.scrollIntoView({ behavior: 'smooth' });
                }
              });
        },
        typePayed(){
            if(this.userData.type_call == 'Telegram') {return'Telegram'}
            else if (this.userData.type_call == 'Whatsapp') {return'Whatsapp'}
            else {return'Телефон'}
        },
        fetchCompanies() {
          this.isLoading = true; // Включаем индикатор загрузки
          fetch('/api/get_companies')
            .then(response => response.json())
            .then(data => {
              this.companies = data;
            })
            .finally(() => {
              this.isLoading = false; // Выключаем индикатор загрузки после завершения
              this.isFullLoading = false;
            })
            .catch(error => {
              console.error("Ошибка при получении марок:", error);
              this.isLoading = false; // Выключаем индикатор загрузки при ошибке
              this.isFullLoading = false;
            });
        },
        fetchModels() {
          if (this.findCar.mark.id) {
            this.isLoading = true; // Включаем индикатор загрузки
            fetch(`/api/get_models/${this.findCar.mark.id}`)
              .then(response => response.json())
              .then(data => {
                if (data.error) {
                  console.error("Ошибка при получении моделей:", data.error);
                } else {
                  this.models = data;
                }
              })
              .finally(() => {
                this.isLoading = false; // Выключаем индикатор загрузки после завершения
              })
              .catch(error => {
                console.error("Ошибка при запросе моделей:", error);
                this.isLoading = false; // Выключаем индикатор загрузки при ошибке
              });
          } else {
            this.models = [];
            this.isLoading = false;
          }
        },
        fetchYears() {
          if (this.findCar.model.id) {
            this.isLoading = true; // Включаем индикатор загрузки
            fetch(`/api/get_years/${this.findCar.model.id}`)
              .then(response => response.json())
              .then(data => {
                if (data.error) {
                  console.error("Ошибка при получении машин:", data.error);
                } else {
                  this.years = data;
                }
              })
              .finally(() => {
                this.isLoading = false; // Выключаем индикатор загрузки после завершения
              })
              .catch(error => {
                console.error("Ошибка при запросе машин:", error);
                this.isLoading = false; // Выключаем индикатор загрузки при ошибке
              });
          } else {
            this.years = [];
            this.isLoading = false;
          }
        },
        fetchConfigurations() {
          if (this.findCar.car.id) {
            this.isLoading = true; // Включаем индикатор загрузки
            fetch(`/api/get_configurations/${this.findCar.car.id}`)
              .then(response => response.json())
              .then(data => {
                if (data.error) {
                  console.error("Ошибка при получении комплектации:", data.error);
                } else {
                  this.configurations = data;
                }
              })
              .finally(() => {
                this.isLoading = false; // Выключаем индикатор загрузки после завершения
              })
              .catch(error => {
                console.error("Ошибка при запросе моделей:", error);
                this.isLoading = false; // Выключаем индикатор загрузки при ошибке
              });
          } else {
            this.configurations = [];
            this.isLoading = false;
          }
        }

        
    },
    mounted() {
        this.fetchCompanies();
      },
    beforeDestroy() {
        
      }
});

