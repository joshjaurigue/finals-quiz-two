<template>
    <!--Nav bar-->
    <nav class="nav-bar">
      <div class="nav-container">
        
      </div>
    </nav>

</template>

<script>

</script>

<style scoped>
.container {
  padding: 20px;
}
.table-striped {
  width: 100%;
  border-collapse: collapse;
}
.table-striped th, .table-striped td {
  border: 1px solid #ddd;
  padding: 8px;
}
.table-striped tr:nth-child(even) {
  background-color: #f2f2f2;
}
.table-striped th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #00aca0;
  color: white;
}

.nav-bar {
  background-color: #4c4d4e; /* Changed to a blue color */
  padding: 1em 2em;
  border-bottom: 2px solid #141414;
  border-top: 2px solid #141414;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav-brand {
  font-size: 1.5em;
  font-weight: bold;
  color: #ffffff;
  text-decoration: none;
}

.nav-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 1em;
}

.nav-link {
  text-decoration: none;
  color: #fff;
}

.nav-link:hover {
  text-decoration: underline;
}
</style>
