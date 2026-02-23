<?php
class Usuarios
{
	private $pdo;
    
    public $idUsuario;
    public $Tipo;
    public $Cedula;
    public $Nombre;
    public $Apellido;
    public $FechaRegistro;
    public $Genero;
    public $edad;
    public $tipoT;
    public $telefono;


    public $Email;
    public $Password;
    public $Nivel;



	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = Database::Conectar();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT 

				tblusuario.idUsuario,
				tblusuario.tipo,	
				tblusuario.cedula,
				tblusuario.nombre,
				tblusuario.apellido,
				tblusuario.fechacrea,
	            tblusuario.genero,
	            tblusuario.edad,
				tblusuario.tipoT,
				tblusuario.telefono,							
				usuario.id_user,
	            usuario.email,
	            usuario.password,
	            usuario.nivel,
	            usuario.idUsuario,

	            FROM tblusuario
				INNER JOIN usuario ON tblusuario.idUsuario = usuario.idUsuario;");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($idUsuario)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT 
				tblusuario.idUsuario,
				tblusuario.tipo,	
				tblusuario.cedula,
				tblusuario.nombre,
				tblusuario.apellido,
				tblusuario.fechacrea,
	            tblusuario.genero,
	            tblusuario.edad,
				tblusuario.tipoT,
				tblusuario.telefono,				
				usuario.id_user,
	            usuario.email,
	            usuario.password,
	            usuario.nivel,
	            usuario.idUsuario,

	            FROM tblusuario
				INNER JOIN usuario ON tblusuario.idUsuario = usuario.idUsuario

						WHERE tblusuario.idUsuario = ?;");
			          
			$stm->execute(array($idUsuario));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($idUsuario)
	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("DELETE FROM tblusuario WHERE idUsuario = ?");			          

			$stm->execute(array($idUsuario));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar($data)
	{
		try 
		{
			$sql = "UPDATE tblusuario SET 
				   Tipo = ?,
                   Cedula = ?, 
                   Nombre = ?,
                   Apellido = ?,
                   Fechacrea = ?,
                   Genero = ?,
                   edad = ?,
                   tipoT = ?,
                   telefono = ?,                
            

			       WHERE idUsuario = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   
       	  		   $data->Tipo,
				   $data->Cedula,
				   $data->Nombre,
                   $data->Apellido, 
           		   $data->Fechacrea,
           		   $data->Genero,
                   $data->edad,
                   $data->tipoT,
                   $data->telefono,
                 	
                   
                        
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Alumno $data)
	{
		try 
		{
		$sql = "INSERT INTO tblusuario (idUsuario,tipo,cedula,nombre,apellido,fechacrea,genero,edad,tipoT,telefono) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	
		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idUsuario = NULL,	
				   $data->Tipo,
				   $data->Cedula,
				   $data->Nombre,
                   $data->Apellido, 
           		   $data->Fechacrea,
           		   $data->Genero,
                   $data->edad,
                   $data->tipoT,
                   $data->telefono,
              
              
                )
			);
  
			$dato=$this->lafuncion();
 
	 	  	$tt= "INSERT INTO usuario (id_user,email,password,nivel,idUsuario) VALUES (?, ?, ?, ?, '".$dato[0]."')";


			$this->pdo->prepare($tt)
		     ->execute(
				array(
				   $data->id_user=Null,	
				   $data->Email,
				   $data->Password, 
				   $data->Nivel,   
          
                   
                )
                );

				return $funcion; 
				} catch (Exception $e) 
				{
					die($e->getMessage());
				}
				
			}


		public function validarUsuario ($Email, $Password)

	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("SELECT  email , password FROM usuario WHERE email = '$Email' AND password = '$Password'");			          

				$stm->execute(array($Email,$Password));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


		public function validarNivel ($Email)

	{
		try 
		{
			$stm = $this->pdo
			            ->prepare("SELECT  nivel FROM usuario WHERE email = '$Email'");			          

				$stm->execute(array($Email));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}




		public function lafuncion()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idUsuario) as 'valor'  FROM tblusuario");

			     	$stm->execute();
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}


}