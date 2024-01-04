(()=>{var e,t={785:(e,t,n)=>{"use strict";var r=document.getElementById("mainNav"),o=function(){window.scrollY<=10?r.classList.remove("navbar-shrink"):r.classList.add("navbar-shrink")};var a=document.getElementById("moodchart"),i={1:"😖",2:"️☹️",3:"😐",4:"🙂",5:"😃"};var s=Array.from(document.getElementsByClassName("js-formaction")),c=document.getElementById("formcontainer"),d={application:"ApplicationForm",note:"NoteForm",interview:"InterviewForm",statusupdate:"StatusUpdateForm"},l=function(){c.innerHTML="",c.insertAdjacentHTML("beforeend",'<div class="text-center">\n  <div class="spinner-border" role="status">\n    <span class="visually-hidden">Loading...</span>\n  </div>\n</div>'),tinyMCE.remove()};var u=function e(){Array.from(document.getElementsByTagName("form")).forEach((function(t){t.addEventListener("submit",(function(n){l(),n.preventDefault(),t.children.find;var r=new FormData(t);l(),fetch(t.action,{method:t.method,body:r,headers:{"x-requested-with":"XMLHttpRequest"}}).then((function(e){return e.json()})).then((function(t){!1!==t.success&&!1!==t.form?(c.innerText="",c.insertAdjacentHTML("beforeend",t.form),tinyMCE.init({selector:"textarea.htmleditor",skin:"silverstripe",max_height:250,menubar:!1,statusbar:!1}),e()):(l(),setTimeout((function(){window.location.reload()}),500))})).catch((function(e){c.innerText="It seems something went wrong. Please try again?",setTimeout((function(){throw window.location.reload(),new Error(e)}),5e3)}))}))}))},m=Array.from(document.getElementsByClassName("js-moodtracker")),f=Array.from(document.getElementsByClassName("js-dayscore"))[0],h=function(e){m.forEach((function(t){var n=parseInt(t.getAttribute("data-score"));t.children[0].classList.remove("h3"),n!==e?(t.parentElement.classList.add("opacity-50"),t.parentElement.classList.add("text-muted"),t.children[0].classList.add("h4")):(t.classList.add("active"),t.parentElement.classList.add("p-0"),t.children[0].classList.add("h2")),t.outerHTML=t.outerHTML}))};var v=document.getElementsByClassName("showOnClick")[0],p=document.getElementsByClassName("showOnClickContainer")[0];n(22);void 0!==navigator.getEnvironmentIntegrity&&(document.querySelector("body").innerHTML='<div class="container"><h1>Your browser contains Google DRM</h1>"Web Environment Integrity" is a Google euphemism for a DRM that is designed to prevent ad-blocking. In support of an open web, this website does not function with this DRM. Please install a browser such as <a href="https://www.mozilla.org/en-US/firefox/new/">Firefox</a> that respects your freedom and supports ad blockers.</div>'),r&&(o(),document.addEventListener("scroll",o)),function(){if(window.chart){var e={type:"line",data:{labels:window.chart.labels,datasets:[{label:"Mood",data:window.chart.values,borderWidth:1}]},options:{scales:{y:{min:1,max:5,ticks:{callback:function(e,t,n){var r;return null!==(r=i[e])&&void 0!==r?r:""},font:{size:25}}}}}};new Chart(a,e)}}(),document.getElementById("addItemModal").addEventListener("hidden.bs.modal",(function(e){l(),tinyMCE.remove()})),s.forEach((function(e){e.addEventListener("click",(function(){var t=e.getAttribute("data-itemtype").split("-"),n="".concat("formhandling/").concat(d[t[0]]),r=0;t.length>1&&("add"===t[1]&&(r=e.getAttribute("data-application")),"edit"===t[1]&&(r=e.getAttribute("data-id")),n="".concat(n,"/").concat(t[1],"/").concat(r)),l(),fetch(n,{method:"GET",headers:{"x-requested-with":"XMLHttpRequest"}}).then((function(e){return e.json()})).then((function(e){c.innerHTML="",e.success&&!1!==e.form?(c.insertAdjacentHTML("beforeend",e.form),tinyMCE.init({selector:"textarea.htmleditor",skin:"silverstripe",max_height:250,menubar:!1,statusbar:!1}),u()):(l(),setTimeout((function(){window.location.reload()}),1e3))}))}))})),function(){if(f&&f.hasAttribute("data-dayscore")){var e=parseInt(f.getAttribute("data-dayscore"));h(e)}m.forEach((function(e){e.addEventListener("click",e.moodHandler=function(){!function(e){var t=e.getAttribute("data-score");fetch("/mood",{method:"POST",headers:{"x-requested-with":"XMLHttpRequest"},body:JSON.stringify({mood:t})}).then((function(e){return e.json()})).then((function(e){var t=parseInt(e.mood);h(t)}))}(e)})}))}(),function(){if(v){var e=v.querySelectorAll("a")[0];e&&e.addEventListener("click",(function(e){e.preventDefault();var t=p.classList;t.contains("d-none")?t.remove("d-none"):t.add("d-none")}))}}()},22:()=>{function e(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var t,n=document.querySelectorAll('[data-bs-toggle="popover"]');(t=n,function(t){if(Array.isArray(t))return e(t)}(t)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(t)||function(t,n){if(t){if("string"==typeof t)return e(t,n);var r=Object.prototype.toString.call(t).slice(8,-1);return"Object"===r&&t.constructor&&(r=t.constructor.name),"Map"===r||"Set"===r?Array.from(t):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?e(t,n):void 0}}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()).map((function(e){console.log(e),new bootstrap.Popover(e)}))},981:()=>{},11:()=>{}},n={};function r(e){var o=n[e];if(void 0!==o)return o.exports;var a=n[e]={exports:{}};return t[e](a,a.exports,r),a.exports}r.m=t,e=[],r.O=(t,n,o,a)=>{if(!n){var i=1/0;for(l=0;l<e.length;l++){for(var[n,o,a]=e[l],s=!0,c=0;c<n.length;c++)(!1&a||i>=a)&&Object.keys(r.O).every((e=>r.O[e](n[c])))?n.splice(c--,1):(s=!1,a<i&&(i=a));if(s){e.splice(l--,1);var d=o();void 0!==d&&(t=d)}}return t}a=a||0;for(var l=e.length;l>0&&e[l-1][2]>a;l--)e[l]=e[l-1];e[l]=[n,o,a]},r.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={546:0,47:0,200:0};r.O.j=t=>0===e[t];var t=(t,n)=>{var o,a,[i,s,c]=n,d=0;if(i.some((t=>0!==e[t]))){for(o in s)r.o(s,o)&&(r.m[o]=s[o]);if(c)var l=c(r)}for(t&&t(n);d<i.length;d++)a=i[d],r.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return r.O(l)},n=self.webpackChunk=self.webpackChunk||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})(),r.O(void 0,[47,200],(()=>r(785))),r.O(void 0,[47,200],(()=>r(981)));var o=r.O(void 0,[47,200],(()=>r(11)));o=r.O(o)})();
//# sourceMappingURL=main.js.map