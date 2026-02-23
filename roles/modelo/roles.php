<?php
class Roles
{
	private $pdo;
    
    public $idRol;
    public $nombreRol;
    public $descripcionRol;
    public $estadoRol;




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

	public function Roles()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM roles");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idRol)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM roles
        WHERE idRol = ?;");
			          
			$stm->execute(array($idRol));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerNombreRol($nombreRol)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM roles
        WHERE nombreRol = ?;");
			          
			$stm->execute(array($nombreRol));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Roles $data)
	{
		try 
		{


		$sql = "INSERT INTO roles (idRol,nombreRol, descripcionRol, estadoRol) 
		        VALUES (?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idRol = NULL,
				   $data->nombreRol,	
				   $data->descripcionRol,
				   $data->estadoRol

                )
			);		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarRol($data)
	{
		try 
		{
			$sql = "UPDATE roles SET 
				  	nombreRol = ?,
				    descripcionRol = ?,
				    estadoRol = ?

			       WHERE idRol = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->nombreRol,
                   $data->descripcionRol,
                   $data->estadoRol,
                   $data->idRol


					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idBus)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM roles WHERE idRol = ?");			          

			$stm->execute(array($idBus));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
