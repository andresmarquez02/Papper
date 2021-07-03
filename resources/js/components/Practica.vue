<template>
    <div>
        <main class="container" :class="container">
            <header class="nav__top nav_container ">
                <section>
                    <h3 class="d__inline cursor__pointer" style="width: 42%">
                        <h3 class="cursor__pointer ver_bar">
                            <i class="fa fa-align-center" aria-hidden="true" v-on:click="show()"></i>
                        </h3>
                        Raptor
                    </h3>
                    <input type="text" class="input d__inline" placeholder="Seach">
                </section>
                <section class="end">
                    <nav>
                        <span class="d__inline icons">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                        </span>
                        <span class="d__inline icons">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        <span class="d__inline icons">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </span>
                        <img src="img/avatar-2.jpg" class="d__inline circle avatar" />
                        <span class="d__inline icons">
                            Alice Nice
                        </span>
                    </nav>
                </section>
            </header>
            <section class="mt_barr">
                <div class="bar__left">
                    <div class="button__close">
                        <h3 class="d__inline">
                            <i class="fa fa-align-center" aria-hidden="true" v-on:click="show()"></i>
                        </h3>
                    </div>
                    <div class="center">
                        <img src="img/avatar-2.jpg" class="d__inline circle avatar_bar" />
                    </div>
                    <ul class="list__user">
                        <li class="position_relative">
                            <h3>
                                <i class="fa fa-user-circle" aria-hidden="true"></i>
                                <span class="ver">Home</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Home
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        <li class="position_relative">
                            <h3>
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span class="ver">Seed</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Seed
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        <li class="position_relative">
                            <h3>
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                <span class="ver">Statistic</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Statistic
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        <li class="position_relative">
                            <h3>
                                <i class="fas fa-money-bill    "></i>
                                <span class="ver">Finance</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Finance
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        <li class="position_relative">
                            <h3>
                                <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                <span class="ver">Retainer</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Retainer
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        <li class="position_relative">
                            <h3>
                                <i class="fas fa-comment-dots    "></i>
                                <span class="ver">Chats</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Chats
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                        <li class="position_relative">
                            <h3>
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                <span class="ver">Log out</span>
                            </h3>
                            <div>
                                <div class="tooltip">
                                    <div class="tooltip__container">
                                    Log out
                                    </div>
                                    <div class="tooltip__flech">
                                        <div class="flech">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="content__global">
                <div class="content_overflow">
                    <section class=" p__1 row welcome_dashboard">
                        <div class="pl__3">
                            <h3>Raptor</h3>
                            Welcome Alice Nice
                        </div>
                       <div class="end pr__3">
                            <h3> Dashboard</h3>
                       </div>
                    </section>
                    <div class="row seed">
                        <div class="list_datas_users">
                            <div class="item__data">
                                <div>
                                    <h2>Member’s performance</h2>
                                </div>
                            </div>
                            <div class="item__data">
                                <div class="row datas_users">
                                    <div>John Doe</div>
                                    <div>
                                        <span class="bolder_font">Inv Excelcior Beta</span>
                                        <br>
                                        <span class="muted_text">New york</span>
                                    </div>
                                    <div class="bolder_font">$304.54</div>
                                </div>
                            </div>
                            <div class="item__data">
                                <div class="row datas_users">
                                    <div>Dave Preston</div>
                                    <div>
                                        <span class="bolder_font">House of motores</span>
                                        <br>
                                        <span class="muted_text">Miami</span>
                                    </div>
                                    <div class="bolder_font">$304.54</div>
                                </div>
                            </div>
                            <div class="item__data">
                                <div class="row datas_users">
                                    <div>Harry Xander</div>
                                    <div>
                                        <span class="bolder_font">Chiles Gustois</span>
                                        <br>
                                        <span class="muted_text">Texas</span>
                                    </div>
                                    <div class="bolder_font">$304.54</div>
                                </div>
                            </div>
                            <div class="item__data">
                                <div class="row datas_users">
                                    <div>Arthur Hoe</div>
                                    <div>
                                        <span class="bolder_font">Pes of mar</span>
                                        <br>
                                        <span class="muted_text">Carolina del Norte</span>
                                    </div>
                                    <div class="bolder_font">$304.54</div>
                                </div>
                            </div>
                        </div>
                        <div class="row equivalences">
                            <div class="item_equivalence">
                                <h4>
                                    Products in inventory
                                </h4>
                                <h2>
                                    400
                                </h2>
                                <span>Products not buyes</span>
                            </div>
                            <div class="item_equivalence">
                                <h4>
                                    Commerces open
                                </h4>
                                <h2>
                                    10
                                </h2>
                                <span>Commerce open</span>
                            </div>
                            <div class="item_equivalence red white__text">
                                <div>30,7%</div>
                                <h2>
                                    $1945,66
                                </h2>
                                <h4>Loss of products</h4>
                            </div>
                            <div class="item_equivalence green white__text">
                                <div>69,3%</div>
                                <h2>
                                    $3945,66
                                </h2>
                                <h4>Gain of products</h4>
                            </div>
                            <div class="item_equivalence">
                                <h4>
                                    Total sales
                                </h4>
                                <h2>
                                    450
                                </h2>
                                <span>41% of products in inventory</span>
                            </div>
                            <div class="item_equivalence">
                                <h4>
                                    Total Buyes
                                </h4>
                                <h2>
                                    950
                                </h2>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row statical">
                        <div class="center">
                            <canvas id="datos" class="small"></canvas>
                        </div>
                        <div class="center">
                            <canvas id="datos2" class="small"></canvas>
                        </div>
                        <div class="center">
                            <canvas id="datos3" class="small"></canvas>
                        </div>
                    </div>
                    <br><br>
                    <div class="row inventary">
                        <div class="item_inventary">
                            <h3>Accounts by collect</h3>
                            <h2>
                                20
                            </h2>
                            <span>40 products by collect</span>
                        </div>
                        <div class="item_inventary">
                            <h3>Accounts by pay</h3>
                            <h2>
                                15
                            </h2>
                            <span>Pay</span>
                        </div>
                        <div class="item_inventary">
                            <h3>Expense generals</h3>
                            <h2>
                                15
                            </h2>
                            <span>Fullfit Follow</span>
                        </div>
                        <div class="item_inventary dolar">
                            <h3>Price of dollar</h3>
                            <h2>
                                PES 1530
                            </h2>
                            <h2>
                                Bs.S 1530
                            </h2>
                            <h2>
                                PEN 1530
                            </h2>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
  <script>
    import Chart from 'chart.js';
    import estadisticas from './LineChart.js'
    export default {
    mounted() {
        this.createChart('datos', this.estadisticas);
        this.createChart('datos2', this.estadisticas2);
        this.createChart('datos3', this.estadisticas3);
    },
    data() {
      return {
        estadisticas: estadisticas.data1,
        estadisticas2: estadisticas.data2,
        estadisticas3: estadisticas.data3,
        container: '',
        scroll: 0,
      }
    },
    methods: {
        createChart(chartId, chartData) {

            Chart.defaults.global.defaultFontFamily = "Arial";
            Chart.defaults.global.defaultFontSize = 25;

          const ctx = document.getElementById(chartId);
          const myChart = new Chart(ctx, {
            type: chartData.type,
            data: chartData.data,
            options: chartData.options,
          });
        },
        show(){
            let b = document.querySelector('body');
            if(this.container === "show"){
                window.scroll(0,this.scroll);
                this.container="";
                b.style.overflowY="auto";
            }
            else{
                this.container = "show";
                b.style.overflowY="hidden";
                this.scroll = window.scrollY;
                window.scroll(0,0);
            }
        }

    }
    }
  </script>
