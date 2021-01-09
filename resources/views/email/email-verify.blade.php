<!DOCTYPE html>
<html lang="en"><head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <style type="text/css">
            td {
                width: 13%;
            }
            td p{
                font-size: 14px!important;
            }
        </style>
    </head>
    <body style="width: 60%; margin: 20px auto;">
<p><br></p>

<div align="left" dir="ltr">
    <table style="border:none;border-collapse:collapse;" width="100%">
        <tbody>
            <tr style="height:0pt;">
                <td style="vertical-align:top;background-color:#ffffff;padding:0pt 18.75pt 0pt 18.75pt;overflow:hidden;overflow-wrap:break-word;"><br>
                    <div align="center" dir="ltr" style="margin-left:0pt;">
                        <table style="border:none;border-collapse:collapse;width: 100%;">
                            <tbody>
                                <tr style="height:0pt;">
                                    <td style="border-left:solid #1f8bcb 0.75pt;border-right:solid #1f8bcb 0.75pt;border-top:solid #1f8bcb 0.75pt;vertical-align:top;padding:22.5pt 0pt 22.5pt 0pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><br><img src="{{asset('img/lock-img.png')}}"></p>
                                    </td>
                                </tr>
                                <tr style="height:0pt;">
                                    <td style="border-left:solid #1f8bcb 0.75pt;border-right:solid #1f8bcb 0.75pt;vertical-align:top;padding:0pt 15pt 15pt 15pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:17.5pt;font-family:Arial;color:#181617;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Hi {{$name}},&nbsp;</span></p>
                                    </td>
                                </tr>
                                <tr style="height:0pt;">
                                    <td style="border-left:solid #1f8bcb 0.75pt;border-right:solid #1f8bcb 0.75pt;vertical-align:top;padding:0pt 15pt 15pt 15pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:12pt;"><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Please verify your email address to complete your account registration.</span></p>
                                    </td>
                                </tr>
                                <tr style="height:0pt;">
                                    <td style="border-left:solid #1f8bcb 0.75pt;border-right:solid #1f8bcb 0.75pt;vertical-align:top;padding:0pt 0pt 15pt 0pt;overflow:hidden;overflow-wrap:break-word;"><br>
                                        <div align="center" dir="ltr" style="margin-left:0pt;">
                                            <table style="border:none;border-collapse:collapse;">
                                                <tbody>
                                                    <tr style="height:0pt;">
                                                        <td style="vertical-align:top;background-color:#8ac866;padding:5.25pt 0pt 5.25pt 0pt;overflow:hidden;overflow-wrap:break-word;">
                                                            <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><a href="{{url('/verifyemail/'.$email_token)}}" style="text-decoration:none;"><span style="font-size:12pt;font-family:Arial;color:#ffffff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:underline;-webkit-text-decoration-skip:none;text-decoration-skip-ink:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;padding: 10px;">VERIFY E-MAIL ADDRESS</span></a></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><br>
                                    </td>
                                </tr>
                                <tr style="height:0pt;">
                                    <td style="border-left:solid #1f8bcb 0.75pt;border-right:solid #1f8bcb 0.75pt;border-bottom:solid #1f8bcb 0.75pt;vertical-align:top;padding:0pt 15pt 15pt 15pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">If the link doesn’t load, copy and paste&nbsp;</span><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><br></span><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">this link into your browser&nbsp;</span></p>
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10.5pt;font-family:Arial;color:#ff0000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">{{url('/verifyemail/'.$email_token)}}&nbsp;</span><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><br><br></span></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div align="left" dir="ltr" style="">
    <table style="border: none; border-collapse: collapse; margin-right: calc(12%); width: 99%;">
        <tbody>
            <tr style="height:0pt;">
                <td style="vertical-align:top;background-color:#ffffff;padding:0pt 18.75pt 0pt 18.75pt;overflow:hidden;overflow-wrap:break-word;"><br>
                    <div align="center" dir="ltr" style="margin-left:0pt;">
                        <table style="border:none;border-collapse:collapse;">
                            <tbody>
                                <tr style="height:0pt;">
                                    <td style="vertical-align:top;padding:22.5pt 0pt 15pt 0pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:18pt;font-family:Arial;color:#4d96d0;background-color:transparent;font-weight:700;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Customer Support</span></p>
                                    </td>
                                </tr>
                                <tr style="height:0pt;">
                                    <td style="vertical-align:top;padding:0pt 0pt 22.5pt 0pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">For further queries, get in touch with us&nbsp;</span></p>
                                        <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">media-training@exceed-media.com or use our&nbsp;</span><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><br></span><span style="font-size:10.5pt;font-family:Arial;color:#686868;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">live chat service.</span></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div align="center" dir="ltr" style="margin-left:0pt;">
    <table style="border: none; border-collapse: collapse;" width="100%">
        <tbody>
            <tr style="height:0pt;">
                <td style="vertical-align:top;background-color:#f2f2f2;padding:22.5pt 0pt 15pt 0pt;overflow:hidden;overflow-wrap:break-word;">
                    <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:6.999999999999999pt;font-family:Arial;color:#575656;background-color:transparent;font-weight:400;font-style:normal;font-variant:small-caps;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">JOIN OUR SOCIAL CIRCLE&nbsp;</span><span style="font-size:6.999999999999999pt;font-family:Arial;color:#575656;background-color:transparent;font-weight:400;font-style:normal;font-variant:small-caps;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><br></span><span style="font-size:6.999999999999999pt;font-family:Arial;color:#575656;background-color:transparent;font-weight:400;font-style:normal;font-variant:small-caps;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">AND FOLLOW US ON</span></p>
                </td>
            </tr>
            <tr style="height:0pt;">
                <td style="vertical-align:top;background-color:#f2f2f2;overflow:hidden;overflow-wrap:break-word;"><br>
                    <div align="center" dir="ltr" style="margin-left:0pt;">
                        <table style="border:none;border-collapse:collapse;">
                            <tbody>
                                <tr style="height:0pt;">
                                    <td style="vertical-align:top;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:12pt;font-family:'Times New Roman';color:#0000ff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><span style="border:none;display:inline-block;overflow:hidden;width:31px;height:31px;"><img alt="Facebook" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAACsklEQVRIS7WVSWgUYRCF3+tuIyJOgmLiQVHxILjdokFBMUIOURJUEGe5BC9ePQuJQcSIoAiCCCpRSA+EgEJE8ZLJyQXUIGoEvQhKBsUFE3Drnn7yDz2h07O4MX3r/qu+v7rqVRVR5cnlck4+n+8GsJ9km6RVAAjgm6QXAMYkXctkMk+rMYxx2ZPNZvdKOg1gTTXHyPcbJI8kk8nXcds58OHhYdvzvPMkD/8BdNZE0jSAZDqdvhX1m4VLouu6LsmDfwOO2PokDySTyeulb7Nw13V7AfT/I7joJumrpNZMJjNp3otw13XXA3gCwI7CJT0iOQ7gHQAvPJsnaSGAZpL7ALTEfO6nUqmtJFWCjxhVxKLucxxn0PO83SSbJM0355ZlSdIXAFO+74/btj1KcnPMtyuVSo2aPLdImiJpRQxeOo7T7vv+cwCNFVL1U9IIyQZJAyQfxqK/nU6nOzk0NHSI5KUY4IqkByQvhrmcDm3eANgJYJOkDpKPHcdp9n3/I4AFJYYkL5FINBn4hQrSOwHgA4CzRmYkt5DcIGkjgCyALgCnDMz3/RbbtidJLpkjQ3Kbgd8h2RH7rX7LsnxJxyUZiHG+Gtp8ArBW0gTJ5SRXB0EwTnJljJExOTdq2BGHF6VE9knqIbkdQE/kt9sBHCW5qwa8p2LkAE4C+G50/1+RV8n5OQBmVhRzbtt2WxAE60whTc4ldZMcCIu9mKTpkRWVcl6mFkmDAO5F1QLgMsm3YQpNQU1HBolEYtHMzMxnAA1laqmi81dBELRblvWsis5LHNN8ZwDcrajzsP3LOpTksUKhYKLtJLlMUrTJTIfmC4XCmG3bN0m2VuzQWrMFwASAnKT3JH+UACQbJRnp7QGwtOZsCS+oz1QMi1O/eW4uqNsmiuatLjs0esFvtr/ZNKbQNbf/L2wtm65SnbIaAAAAAElFTkSuQmCC" width="31" height="31"></span></span></p>
                                    </td>
                                    <td style="vertical-align:top;padding:0pt 0pt 0pt 3.75pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:12pt;font-family:'Times New Roman';color:#0000ff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><span style="border:none;display:inline-block;overflow:hidden;width:31px;height:31px;"><img alt="Twitter" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAACYElEQVRIS7WVv2sUQRTHv9/ZW8UIWgjCWWhEbQIiVpFUnp2CoCALO4uiEju1EcFGIiKmEW0tRPFud1YvRIkHgikUC0UJNoKNEPAPUCKnKYS7fTKnF8e7vYsab8o33/m8N/N+DNFnxXG8k+QxACWSIwDWABCSH0TkFYDpYrE4UyqVGnkY5hnTNB0WkRsADvVz/nNvnuT5MAwfdmq74EmSHACQklz3B+AliYjc9H3/dBAEzbbxN3iapodFpAqg8DfgtlZE7mmtNUmxtiV4HMcjJOdIDv0L2DkzobW+vAQXERpjXpLcs0KwPW6fZZfW+l0rcmPMQQCPOsDfAKzOcfaW5NVms7molDoLYLeILJLc4mintdZHWvAkSR6T3O+CRGQUwBTJzc6bfgKwI4qiBWuzN47jeJvneXcBjDm6jOQm1mq1oXq9/pmk78KzLFuvlFoF4JqI2CTZ/VhrfdTVVavVrY1G4ymA4Y7gxpmm6ZiIvMi5/jmt9XVrL5fLGz3P2wdgIYqiJ67WGHMCwO3O87Y0mSRJRDLO2Rz1ff+NW7d5yU6S5BLJiZzzsxZ+nOSdru4iL4ZheGW56jHGPAOwN0f3vGfktqREJIii6EEvB5VKZbvnee/dfnGSOtvvza3ulNb6Vi+4McbOk9z503rzXtXiRDDl+/7JIAi+diTyAoDJXo5FZDy3zkWkDmBGKfVaRO5rrT+2IeVyeW2hULDQM33AP+q8T4fOi0iqlJrLsuyLUqqYZZltLFtdG5ZJ9K8OHehssVEMbCq2r/gf5rnNT9g1z9sOBvYTOTcYzB/qVsFKf//vzP8y64jERGsAAAAASUVORK5CYII=" width="31" height="31"></span></span></p>
                                    </td>
                                    <td style="vertical-align:top;padding:0pt 3.75pt 0pt 3.75pt;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:12pt;font-family:'Times New Roman';color:#0000ff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><span style="border:none;display:inline-block;overflow:hidden;width:31px;height:31px;"><img alt="Instagram" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAACsklEQVRIS7WVSWgUYRCF3+tuIyJOgmLiQVHxILjdokFBMUIOURJUEGe5BC9ePQuJQcSIoAiCCCpRSA+EgEJE8ZLJyQXUIGoEvQhKBsUFE3Drnn7yDz2h07O4MX3r/qu+v7rqVRVR5cnlck4+n+8GsJ9km6RVAAjgm6QXAMYkXctkMk+rMYxx2ZPNZvdKOg1gTTXHyPcbJI8kk8nXcds58OHhYdvzvPMkD/8BdNZE0jSAZDqdvhX1m4VLouu6LsmDfwOO2PokDySTyeulb7Nw13V7AfT/I7joJumrpNZMJjNp3otw13XXA3gCwI7CJT0iOQ7gHQAvPJsnaSGAZpL7ALTEfO6nUqmtJFWCjxhVxKLucxxn0PO83SSbJM0355ZlSdIXAFO+74/btj1KcnPMtyuVSo2aPLdImiJpRQxeOo7T7vv+cwCNFVL1U9IIyQZJAyQfxqK/nU6nOzk0NHSI5KUY4IqkByQvhrmcDm3eANgJYJOkDpKPHcdp9n3/I4AFJYYkL5FINBn4hQrSOwHgA4CzRmYkt5DcIGkjgCyALgCnDMz3/RbbtidJLpkjQ3Kbgd8h2RH7rX7LsnxJxyUZiHG+Gtp8ArBW0gTJ5SRXB0EwTnJljJExOTdq2BGHF6VE9knqIbkdQE/kt9sBHCW5qwa8p2LkAE4C+G50/1+RV8n5OQBmVhRzbtt2WxAE60whTc4ldZMcCIu9mKTpkRWVcl6mFkmDAO5F1QLgMsm3YQpNQU1HBolEYtHMzMxnAA1laqmi81dBELRblvWsis5LHNN8ZwDcrajzsP3LOpTksUKhYKLtJLlMUrTJTIfmC4XCmG3bN0m2VuzQWrMFwASAnKT3JH+UACQbJRnp7QGwtOZsCS+oz1QMi1O/eW4uqNsmiuatLjs0esFvtr/ZNKbQNbf/L2wtm65SnbIaAAAAAElFTkSuQmCC" width="31" height="31"></span></span></p>
                                    </td>
                                    <td style="vertical-align:top;overflow:hidden;overflow-wrap:break-word;">
                                        <p dir="ltr" style="line-height:1.2;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:12pt;font-family:'Times New Roman';color:#0000ff;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><span style="border:none;display:inline-block;overflow:hidden;width:31px;height:31px;"><img alt="YouTube" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAXCAYAAADgKtSgAAAB/UlEQVRIS7WVMYgTQRSG/393Q87YRBAsbO7A5hBEWwu1sBDUIs3CsEFIFVEEwUYrU6h4IFhaBhIzE4KVXOM1J1gJooWFQpQTCzkUREIkB+byZI5smHh7WeKxU8578703b/73hpixtNZHAFwBcEFETpE8ZN1F5DvJtyRXfd83YRj+TMIwabPRaBwMguCuiNwguTArARH57Xnew16vt1KtVv+4vrvgzWbzmO/7zwEsz4Im2F4HQXA5DMMfsW0K3ul0lobD4SsAR+cE77iLyKdcLnc6DjCB1+v1hXw+/wbA8f8Bx2dEZL3b7Z6v1WqjCVxr/QDAnf2AnQDXoih6sgPXWh8G8BXAAcdhjeSHtGAiYhknSZ5xfDeLxeJiDL8F4JEDXomi6HYa2LW3Wq2nJCOHoWL4SwBnY8NoNDpRLpffu4fb7fbyYDDYqFQqW0lBjTEXRWTVgbdor6W17pMsTCRELimlvrgQrfVNEbnqeV5ZKWUffmoZY87Zx3Q2P1uw7cLNKfHvAQfwGMC2iNzr9/v33aZJgG/TGLMoIhtzwK3rN5KXlFLv4nMJcMyduYjoQqFwvVQq/XITSsx8jpqXSW4ppZ7t8aC7az7Weapa0mSZqJYxPFOdJ3XoC5If0zJO7dBx9tnMFgvPdCraAJnN87i2mf1EcYDM/tB/htW+fv+/AolUljC29vsAAAAASUVORK5CYII=" width="31" height="31"></span></span></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                </td>
            </tr>
            <tr style="height:0pt;">
                <td style="vertical-align:top;background-color:#f2f2f2;padding:18.75pt 0pt 15pt 0pt;overflow:hidden;overflow-wrap:break-word;">
                    <p dir="ltr" style="line-height:1.2;text-align: center;margin-top:0pt;margin-bottom:0pt;"><span style="font-size:6.999999999999999pt;font-family:Arial;color:#545454;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">&nbsp;Exceed Media&nbsp;</span><span style="font-size:6.999999999999999pt;font-family:Arial;color:#545454;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;"><br></span><span style="font-size:6.999999999999999pt;font-family:Arial;color:#545454;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;">Concord Tower Dubai Media City, Dubai, UAE</span></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<p><br></p>
<p><br></p>

</body>
</html>