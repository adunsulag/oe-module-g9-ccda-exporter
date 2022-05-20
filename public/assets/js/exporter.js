var storedClient = null;
        var storedData = null;
        var patientName = null;
        var currentDate = new Date();
        var exportFileNameParts = [currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDay(), currentDate.getHours(), currentDate.getMinutes()];

            FHIR.oauth2.ready().then(function(client) {

                function downloadCCDA() {
                    if (!storedData) {
                        console.error("download called without any ccda");
                        return;
                    }
                    const url = window.URL
                        .createObjectURL(new Blob([storedData]));
                        const fileName = "CCDA_" + exportFileNameParts.join("_") + ".xml";
                        const link = document.createElement('a');
                              link.href = url;
                              link.setAttribute('download', fileName);
                              document.body.appendChild(link);
                              link.click();
                              document.body.removeChild(link);
                }

                function generateCCDA(client) {
                    let resource = "DocumentReference/$docref";
                    let start = document.getElementById('start').value || "";
                    let end= document.getElementById('end').value || "";

                    let params = [];
                    if (start) {
                        params.push("start=" + start);
                    }
                    if (end) {
                        params.push("end=" + end);
                    }

                    if (client.patient.id) {
                        params.push("patient=" + client.patient.id);
                    }

                    operation = resource;
                    if (params.length) {
                        operation += "?" + params.join("&");
                    }

                    document.getElementById('progress').classList.remove('d-none');
                    client.request({
                        url: "/" + operation
                        ,method: "GET"
                    })
                    //client.patient.request(operation)
                    .then(function(result) {
                        console.log("Result of operation is ", result);
                        if (!result.entry.length) {
                            console.error("Failed to generate ccda document");
                            return;
                        }
                        let ccdaUrl = result.entry[0].resource.content[0].attachment.url;
                        if (ccdaUrl) {
                            ccdaUrl = ccdaUrl.replace("/fhir","");
                            client.request(ccdaUrl)
                            .then(fileResponse => {
                                if (typeof fileResponse == 'string') {
                                    document.getElementById('progress').classList.add('d-none');
                                    console.log("ccdaText is ", fileResponse);
                                    storedData = fileResponse;
                                    document.getElementById('ccda-contents').value = fileResponse;
                                    document.getElementById('ccda-contents-container').classList.remove('d-none');

                                } else {
                                    console.error("Server returned something other than a ccda text document");
                                }
                            });
                        }
                    });
                }

		    storedClient = client;

		    console.log("Current patient is: ", client.patient.id);

                // Render the current patient (or any error)
                client.patient.read().then(
                    function(pt) {
                        document.getElementById("patient").innerText = JSON.stringify(pt, null, 4);
                        console.log("patient is ", pt);
                        if (pt.name && pt.name.length) {
                            exportFileNameParts = pt.name[0].given.concat(exportFileNameParts);
                            exportFileNameParts.unshift(pt.name[0].family);
                        }
                    },
                    function(error) {
                        document.getElementById("patient").innerText = error.stack;
                    }
                );

                // setup our generateccda
                window.document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById('ccda').addEventListener('click', generateCCDA.bind(null, client));
                    document.getElementById('download').addEventListener('click', downloadCCDA);
                });

		}).catch(console.error);
