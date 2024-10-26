<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <title>Web to pdf in Laravel</title>
    <style>
        button{
            height: 50px;
            font-size:1em;
            transition:background-color .1s linear;
        }
        button:hover{
            background-color: #f49494;
        }
    </style>
</head>
<body class="main-content">
    <header class="section sec1 header active" id="home">
        <div class="header-content">
          <div class="left-header">
            <div class="h-shape"></div>
            <div class="image">
              <img src="./img/hero.png" alt="" />
            </div>
          </div>
          <div class="right-header">
            <h1 class="name">
              Hi, I'm <span>Aryan Khandelwal.</span><br />
              A web developer.
            </h1>
            <p>
              Hey there! It's Aryan here. I welcome you to my small world of web
              universe where I experiment with things and develop new features.
              This site tracks all my work, achievements, projects, and awards I
              have received so far. I hope this website meets your expectations
              and you find what you are looking for. You can contact me by
              reaching out to the contact section. Thank you
            </p>
            
            <button onclick="downloadPDF(this,event)">Download Full Page as PDF</button>
          </div>
        </div>
      </header>
    <script>
        function downloadPDF() {
            const contentToSend = document.documentElement.outerHTML;
            // console.log(contentToSend);
            const formData = new FormData();
            formData.append("htmlContent", contentToSend);
            console.log(formData.get("htmlContent"));
            fetch("{{ route('generate_pdf') }}", { // Adjust the route name accordingly
                method: "POST",
                body: formData,
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
    }
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok, status code:'+response.status);}
                return response.blob();
            }).then(blob=>{
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href=url
                a.download = "generated_pdf.pdf"
                document.body.appendChild(a);
                a.click();
                a.remove(); // Clean up
            })
            .catch(error=>console.error("error:",error));
    }
    </script>
</body>
</html>