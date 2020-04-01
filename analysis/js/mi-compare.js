fetch('results.json')
    .then((response) => {
        return response.json();
    })
    .then((results) => {
        let top = results.analysis.slice(0, 85);
        let bottom = results.analysis.slice(-85);

        let topData = top.map((item) => {
            return parseInt(item.maintainability_index);
        });

        let bottomData = bottom.map((item) => {
            return parseInt(item.maintainability_index);
        });

        let labels = [];

        for (let i =0; i < 85; i++) {
            labels.push("");
        }

        new Chart(document.getElementById("mixed-chart-mi"), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: "populaire",
                    type: "line",
                    borderColor: "#8e5ea2",
                    data: topData,
                    fill: false
                }, {
                    label: "moins populaire",
                    type: "line",
                    borderColor: "#3e95cd",
                    data: bottomData,
                    fill: false
                }, {
                    label: "populaire",
                    type: "bar",
                    backgroundColor: "rgba(0,0,0,0.2)",
                    data: topData,
                }, {
                    label: "moins populaire",
                    type: "bar",
                    backgroundColor: "rgba(0,0,0,0.2)",
                    backgroundColorHover: "#3e95cd",
                    data: bottomData
                }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Comparaison de la qualite entre les librairies populaires et les moins populaires - mi'
                },
                legend: {display: false}
            }
        });
    });
