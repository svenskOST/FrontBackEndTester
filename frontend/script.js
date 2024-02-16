const responseContainer = document.getElementById('responseContainer')

const fetchData = async () => {
   try {
      const response = await fetch(
         // Location of the backend entry point
         'http://localhost:8080/projects/folders-to-elements/folders-to-elements.php'
      )

      const content = await response.text()

      responseContainer.innerHTML =
         '<a id="urlText" href="' +
         response.url +
         '">' +
         response.url +
         '</a>' +
         ' responded with:'

      const responseText = document.createElement('p')
      responseText.id = 'responseText'
      responseText.textContent = content
      responseContainer.appendChild(responseText)
   } catch (error) {
      console.error(error)
   }
}

fetchData()
