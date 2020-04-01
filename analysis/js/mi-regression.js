fetch('results.json')
    .then((response) => {
        return response.json();
    })
    .then((results) => {
        const rawData = results.regression.mi;

        let result = regression('linear', rawData); // getting the regression object
        let coefficient = result.equation; // get coefficients from the calculated formula

        anychart.onDocumentReady(function () {

            const raw = rawData;
            const data = setTheoreticalData(rawData, coefficient);

            chart = anychart.scatter();

            chart.title("Equation: " + result.string + "\nCoefficient de détermination (R2): " + result.r2.toPrecision(2));

            chart.legend(true);

            const series1 = chart.marker(raw);
            series1.name("Données de l'expérience");

            const series2 = chart.line(data);
            series2.name("Régression linéaire");
            series2.markers(true);

            chart.container("mi");
            chart.draw();
        });
    });

function setTheoreticalData(rawData, coefficient) {
    let theoryData = [];

    for (let i = 0; i < rawData.length; i++) {
        theoryData[i] = [rawData[i][0], formula(coefficient, rawData[i][0])];
    }

    return theoryData;
}

function formula(coefficient, x) {
    let result = null;
    let i = 0, j = coefficient.length - 1;

    for (; i < coefficient.length; i++, j--) {
        result += coefficient[i] * Math.pow(x, j);
    }

    return result;
}
