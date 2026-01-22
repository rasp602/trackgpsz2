<?php
class Persona
{
	private $pdo;

    
    public $idPersona;
    public $cedulaPersona;
    public $numeroPersona;
    public $nombre1Persona;
    public $nombre2Persona;
    public $apellido1Persona;
    public $apellido2Persona;
    public $fechaIngreso;
    public $direccionPersona;
    public $estadoPersona;
    public $emailPersona;
    public $nTelefonoPersona;
    public $idRol;


  	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = DatabaseLocal::ConectarLocal();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
		public function ListarRoles()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM roles ORDER BY idRol");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarPersonas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM persona ORDER BY idPersona");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Personas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM persona");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}







	public function Obtener($idPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE idPersona = ?;");
			          
			$stm->execute(array($idPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerCedula($cedulaPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE cedulaPersona = ?;");
			          
			$stm->execute(array($cedulaPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


		public function ObtenerID($cedulaPersona)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM persona
        WHERE cedulaPersona = ?;");
			          
			$stm->execute(array($cedulaPersona));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Persona $data)
	{
		try 
		{


		$sql = "INSERT INTO persona (idPersona, cedulaPersona, numeroPersona, nombre1Persona, nombre2Persona, apellido1Persona, apellido2Persona, fechaIngreso,direccionPersona,estadoPersona,emailPersona,nTelefonoPersona,idRol) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idPersona = NULL,	
				   $data->cedulaPersona,
				   $data->numeroPersona,
				   $data->nombre1Persona,
				   $data->nombre2Persona,
				   $data->apellido1Persona,
				   $data->apellido2Persona,
				   $data->fechaIngreso,
				   $data->direccionPersona,
				   $data->estadoPersona,
				   $data->emailPersona,
				   $data->nTelefonoPersona,
				   $data->idRol


               
                   
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarP($data)
	{
		try 
		{
			$sql = "UPDATE persona SET 

				    cedulaPersona = ?,
				    numeroPersona = ?,
				    nombre1Persona = ?,
				    nombre2Persona = ?,
				    apellido1Persona = ?,
				    apellido2Persona = ?,
				    fechaIngreso = ?,
				    direccionPersona = ?,
				    estadoPersona = ?,
				    emailPersona = ?,
				    nTelefonoPersona = ?,
				    idRol = ?


			       WHERE idPersona = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
                   $data->cedulaPersona,
                   $data->numeroPersona,
                   $data->nombre1Persona,
                   $data->nombre2Persona,
                   $data->apellido1Persona,
                   $data->apellido2Persona,
                   $data->fechaIngreso,
                   $data->direccionPersona,
                   $data->estadoPersona,
                   $data->emailPersona,
                   $data->nTelefonoPersona,
                   $data->idRol,
                   $data->idPersona,


					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}



	public function Eliminar($idPersona)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM persona WHERE idPersona = ?");			          

			$stm->execute(array($idPersona));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}



	public function lafuncion()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idPersona)  as 'valor' FROM persona");

			     	$stm->execute(array($idPersona));
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}








}



?>
