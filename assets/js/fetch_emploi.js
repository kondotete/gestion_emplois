
document.addEventListener('DOMContentLoaded', () => {
    const classeId = 1;
    fetch(`http://localhost/emploi-du-temps/php/emploi.php?classe=${classeId}`)
    .then(response => response.text())
    .then(xmlString => {
        const parser = new DOMParser();
        const xml = parser.parseFromString(xmlString, "application/xml");
        const xslRequest = new XMLHttpRequest();
        xslRequest.open("GET", "http://localhost/emploi-du-temps/xsl/emploi.xsl", true);
        xslRequest.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const xsl = parser.parseFromString(this.responseText, "application/xml");
            const xsltProcessor = new XSLTProcessor();
            xsltProcessor.importStylesheet(xsl);
            const resultDocument = xsltProcessor.transformToFragment(xml, document);
            document.getElementById("emploiContainer").appendChild(resultDocument);
            console.log(resultDocument);
        }
        };
        xslRequest.send();
    });
});
