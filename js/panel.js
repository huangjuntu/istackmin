var myChart = echarts.init(document.getElementById("echart"));
// 指定图表的配置项和数据
option = {
    title: {
        text: '统计图表'
    },
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data: ['GDP 月变化', '数据量月变化', '市民满意指数']
    },
    toolbox: {
        feature: {
            saveAsImage: {}
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis: [
        {
            type: 'category',
            boundaryGap: false,
            data: ['2016/1', '2016/2', '2016/3', '2016/4', '2016/5', '2016/6', '2016/7']
        }
    ],
    yAxis: [
        {
            type: 'value'
        }
    ],
    series: [
        {
            name: 'GDP 月变化',
            type: 'line',
            data: [36, 42, 31, 64, 20, 65, 63]
        },
        {
            name: '数据量月变化',
            type: 'line',
            data: [40, 72, 51, 54, 37, 51, 41]
        },
        {
            name: '市民满意指数',
            type: 'line',
            data: [67, 89, 93, 86, 80, 87, 91]
        },

    ]
};
myChart.setOption(option);