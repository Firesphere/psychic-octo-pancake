(()=>{var e=Array.from(document.getElementsByClassName("js-notebook-edit")),o=document.getElementById("NotebookForm_NotebookForm");e.forEach((function(e){e.addEventListener("click",(function(o){o.preventDefault();var t=e.getAttribute("href").replace("/#",""),n=document.getElementById("note-".concat(t,"-title")).innerText,m=document.getElementById("note-".concat(t,"-content")).innerHTML;document.getElementById("NotebookForm_NotebookForm_ID").value=t,document.getElementById("NotebookForm_NotebookForm_Title").value=n,document.getElementById("NotebookForm_NotebookForm_Content").value=m,document.getElementById("notebookFormToggle").dispatchEvent(new Event("click"))}))})),o.addEventListener("show.bs.collapse",(function(e){tinyMCE.remove(),tinyMCE.init({selector:"#offcanvasNotes form textarea.htmleditor",max_height:175,menubar:!1,statusbar:!1})})),o.addEventListener("hidden.bs.collapse",(function(){tinyMCE.remove(),document.getElementById("NotebookForm_NotebookForm_ID").value="",document.getElementById("NotebookForm_NotebookForm_Title").value="",document.getElementById("NotebookForm_NotebookForm_Content").value=""}))})();
//# sourceMappingURL=main.js.map