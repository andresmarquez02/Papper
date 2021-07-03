

const Data1 = {
    type: 'doughnut',
    data: {
      labels: ['Calzado','Ropa Intima','Blusas y Camisas','Pantalones','Ropa de niños'],
      datasets: [
        { // one line graph
          label: 'Cantidad en ALmacen',
          data: [2, 10, 6, 7, 9],
          backgroundColor: [
            '#f11022', // Blue
            '#ff3a4a',
            '#c70918',
            '#e4545f',
            '#ff3e85',
          ],
          borderColor: [
            '#36495d',
            '#36495d',
            '#36495d',
            '#36495d',
            '#36495d',
          ],
          borderWidth: 2,
          fontFamily: "cursive"
        },
      ]
    },
    options: {
      responsive: true,
      lineTension: 1,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            padding: 25,
          }
        }]
      }
    }
  }
const Data2 = {
    type: 'line',
    data: {
        labels: ['CZ','R.I','B&C','PT','RNÑ'],
        datasets: [
        { // one line graph
            label: ['General'],
            data: [12, 20, 11, 23, 30],
          backgroundColor: 'rgb(168,185,185,6%)',
          borderColor: [
            '#36495d',
            '#36495d',
            '#36495d',
            '#36495d',
            '#36495d',
          ],
          borderWidth: 3,
          fontFamily: "cursive"
        },
        { // another line graph
          label: ['Prenda mas vendida'],
          data: [4.8, 21.1, 12.7, 6.7, 19.8],
          backgroundColor: [
            'rgba(46,255,255,45%)', // Green
          ],
          borderColor: [
            'rgba(46,255,255,99%)',
          ],
          borderWidth: 3,
          fontFamily: "cursive"
        },
        { // another line graph
            type: 'bar',
            label: 'Prenda mas costosa',
            data: [20, 12.1, 12.7, 6.7, 19.8],
            backgroundColor: [
              'rgb(24,208,199,65%)', // Green
            ],
            borderColor: [
              '#47b784',
            ],
            borderWidth: 3,
            fontFamily: "cursive"
          }
      ]
    },
    options: {
      responsive: true,
      lineTension: 1,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            padding: 25,
          }
        }]
      }
    }
  }
  const Data3 = {
    type: 'bubble',
    data: {
        labels: ['Calzado','Ropa Intima','Blusas y Camisas','Pantalones','Ropa de niños'],
        datasets: [{
        label: ['Mas popular'],
        data: [{
          x: 100,
          y: 0,
          r: 10
        }, {
          x: 60,
          y: 30,
          r: 20
        }, {
          x: 40,
          y: 60,
          r: 25
        }, {
          x: 80,
          y: 80,
          r: 50
        }, {
          x: 20,
          y: 30,
          r: 25
        }, {
          x: 0,
          y: 100,
          r: 5
        }],
        backgroundColor: "#ffac46",
        fontFamily: "cursive",
        fontSize: "1px",
      }]
    },
    options: {
      responsive: true,
      lineTension: 1,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            padding: 25,
          }
        }]
      }
    }
  }
  export const Data = {
      data1: Data1,
      data2: Data2,
      data3: Data3,
  }
  export default Data;
