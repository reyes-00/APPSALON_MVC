let paso=1;const pasoFinal=3,pasoInicial=1,cita={nombre:"",fecha:"",hora:"",usuarioId:"",servicios:[]};function iniciarApp(){tabs(),mostrarTab(),paginacionSiguiente(),paginacionAnterior(),consultarAPI(),nombreCita(),idNombre(),seleccionarFecha(),seleccionarHora()}function tabs(){document.querySelectorAll(".navegacion button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarTab()}))})}function mostrarTab(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar"),document.querySelector("#paso-"+paso).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso ="${paso}" ]`).classList.add("actual"),OcultarMostrarpaginacion()}function OcultarMostrarpaginacion(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(mostrarResumen(),e.classList.remove("ocultar"),t.classList.add("ocultar")):(t.classList.remove("ocultar"),e.classList.remove("ocultar"))}function paginacionSiguiente(){document.querySelector("#siguiente").addEventListener("click",()=>{paso>=3||(paso++,mostrarTab())})}function paginacionAnterior(){document.querySelector("#anterior").addEventListener("click",()=>{paso<=1||(paso--,mostrarTab())})}async function consultarAPI(){try{let e="http://localhost:3000/api/servicios";const t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e;let n=document.createElement("P");n.textContent=o;let c=document.createElement("P");c.classList.add("precio"),c.textContent="$"+a;let r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){muestraServicios(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function muestraServicios(e){const{id:t}=e,{servicios:o}=cita;let a=document.querySelector(`[data-id-servicio = "${t}"]`);o.some(e=>e.id===t)?(cita.servicios=o.filter(e=>e.id!=t),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado")),console.log(cita)}function nombreCita(){cita.nombre=document.querySelector("#nombre").value}function idNombre(){const e=document.querySelector("#id").value;cita.idNombre=e}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarMensaje("Fines de semana no disponibles","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){const e=document.querySelector("#hora");e.addEventListener("input",(function(t){let o=e.value;cita.hora=o.split(":")[0],cita.hora<=8||cita.hora>=18?(cita.hora=t.target.value="",mostrarMensaje("Hora no disponible","error",".formulario")):cita.hora=o}))}function mostrarMensaje(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();let c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t),document.querySelector(o).appendChild(c),a&&setTimeout(()=>{c.remove()},3e3)}function mostrarResumen(){const e=document.querySelector(".contenido_resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes(" ")||0===cita.servicios.length)return console.log(cita),void mostrarMensaje("Faltan datos o Servicios","error",".contenido_resumen",desaparece=!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("P");c.innerHTML=`\n  <span>Nombre: </span>${t}\n  `;const r=new Date(o),i=r.getMonth(),s=r.getDate()+2,l=r.getFullYear(),d=new Date(Date.UTC(l,i,s)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"});console.log(d);const u=document.createElement("P");u.innerHTML=`\n  <span>Fecha: </span>${o}\n  `;const m=document.createElement("P");m.innerHTML=`\n  <span>Hora: </span>${a} Horas\n  `;const p=document.createElement("H3");p.textContent="Resumen de servicios",e.appendChild(p),n.forEach(t=>{const{id:o,precio:a,nombre:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=n;const i=document.createElement("P");i.innerHTML="<span>Precio:</span> $"+a,c.appendChild(r),c.appendChild(i),e.appendChild(c)});const h=document.createElement("BUTTON");h.classList.add("boton"),h.textContent="Reservar Cita",h.onclick=function(){reservarCita()},e.appendChild(c),e.appendChild(u),e.appendChild(m),e.appendChild(h),console.log(e)}async function reservarCita(){const{nombre:e,fecha:t,hora:o,servicios:a,idNombre:n}=cita,c=a.map(e=>e.id),r=new FormData;r.append("hora",o),r.append("fecha",t),r.append("usuarioId",n),r.append("servicios",c);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:r}),o=await t.json();console.log(o.resultado),o.resultado&&Swal.fire({icon:"success",title:"Cita creada...",text:"Tu cita fue creada correctamente!",button:"OK"}).then(()=>{setTimeout(()=>{window.location.reload()},2e3)})}catch(e){Swal.fire({icon:"error",title:"Oops...",text:"Hubo un error al crear tu cita!",button:"OK"}).then(()=>{window.location.reload()})}}document.querySelector("DOMContentLoaded",iniciarApp());