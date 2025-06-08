<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
  <div class="newtilecontainer">
<article class="article-wrapper">
  <div class="rounded-lg container-project clients">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Clients</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Add Clients</span>
             <span class="project-type">• Manage Clients</span>
        </div>
    </div>
</article>

<article class="article-wrapper">
  <div class="rounded-lg container-project bills_tile">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Bills</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Manage Bills</span>
             <span class="project-type">• Generate Bills</span>
        </div>
    </div>
</article>


<article class="article-wrapper">
  <div class="rounded-lg container-project">
    </div>
    <div class="project-info">
      <div class="flex-pr">
        <div class="project-title text-nowrap">Statistics</div>
          <div class="project-hover">
            <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" color="black" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"><line y2="12" x2="19" y1="12" x1="5"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>
          <div class="types">
            <span style="background-color: rgba(165, 96, 247, 0.43); color: rgb(85, 27, 177);" class="project-type">• Open Bill</span>
             <span class="project-type">• Closed Bill</span>
        </div>
    </div>
</article>



</div>
 
</body>
</html>

<style>
  .newtilecontainer{
    width:100%;
    height:50%;
    display:flex;
    align-Items:center;
    justify-content:center;
    margin-top:50px;
    border:1px solid red;
  }
    .article-wrapper {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  width: 210px;
  -webkit-transition: 0.15s all ease-in-out;
  transition: 0.15s all ease-in-out;
  border-radius: 8px;
  padding: 5px;
  border: 2px solid transparent;
  cursor: pointer;
  background-color: white;
  margin-right:40px;
}

.article-wrapper:hover {
  -webkit-box-shadow: 10px 10px 0 #4e84ff, 20px 20px 0 #4444bd;
  box-shadow: 10px 10px 0 #4e84ff, 20px 20px 0 #4444bd;
  border-color: #0578c5;
  -webkit-transform: translate(-20px, -20px);
  -ms-transform: translate(-20px, -20px);
  transform: translate(-20px, -20px);
}

.article-wrapper:active {
  -webkit-box-shadow: none;
  box-shadow: none;
  -webkit-transform: translate(0, 0);
  -ms-transform: translate(0, 0);
  transform: translate(0, 0);
}

.types {
  gap: 10px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  place-content: flex-start;
}

.rounded-lg {
 /* class tailwind */
  border-radius: 8px;
}

.article-wrapper:hover .project-hover {
  -webkit-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  transform: rotate(-45deg);
  background-color: #a6c2f0;
}

.project-info {
  padding-top: 20px;
  padding: 10px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  gap: 20px;
}

.project-title {
  font-size: 1.5em;
  margin: 0;
  width:100%;
  font-weight: 600;
 /* depend de la font */
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: black;
}

.flex-pr {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
}

.project-type {
  background: #b2b2fd;
  color: #1a41cd;
  font-weight: bold;
  padding: 0.3em 0.7em;
  border-radius: 15px;
  font-size: 12px;
  letter-spacing: -0.6px
}

.project-hover {
  border-radius: 50%;
  width: 30px;
  height: 30px;
  padding: 9px;
  -webkit-transition: all 0.3s ease;
  transition: all 0.3s ease;
}

.container-project {
    width: 100%;
    height: 170px;
    background-color: #f0f0f0; /* Set your background color */
    background-size: 30%;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image:url("graph-up-arrow.svg")
}
.clients{
  background-image:url("people-fill.svg")!important;
}
.bills_tile{
  background-image:url("receipt-cutoff.svg")!important;

}
</style>