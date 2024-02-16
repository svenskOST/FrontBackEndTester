const responseContainer = document.getElementById('responseContainer')

const fetchData = async () => {
   try {
      const response = await fetch(
         'http://localhost:8080/projects/folders_to_elements/folders_to_elements.php'
      )

      const content = await response.text()

      responseContainer.innerHTML += content
   } catch (error) {
      console.error(error)
   }
}

fetchData()
