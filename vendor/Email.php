<?php

/*----------------------------------------------
 Integração Mandrill - Modo de Uso
----------------------------------------------*/

/*
	-Instanciar a classe
		
		$email = new Email();

	-Invocar um dos métodos

		* enviarTexto()

			- Endereço do Destinatário (string)
			- Assunto (string)
			- Nome do Destinatário (string)
			- Texto do e-mail (string)

		* enviarHTML()

			- Endereço do Destinatário (string)
			- Assunto (string)
			- Nome do Destinatário (string)
			- Caminho para o arquivo HTML relativo à pasta 'emails' (string sem a '/' inicial)

		* enviarTemplate()

			- Endereço do Destinatário (string)
			- Assunto (string)
			- Nome do Destinatário (string)
			- Slug do template cadastrado no Mandrill (string)
			- Array com as tags de conteúdo do template e o conteúdo de cada uma delas:
				
				array(
					array(
						'name' => "texto-principal",
						'content' => "Texto enviado à partir da tag"
					),
					array(
						'name' => "email",
						'content' => "fulano@example.com"
					),
				)	

	Todos os métodos retornam um array com uma posição 'erro' (bool).
	
	- Caso 'erro' seja false, o e-mail foi enviado sem problemas. 

	- Caso contrário, a posição 'mensagem' desse array trará mais detalhes sobre o erro ocorrido.

*/

//Importar a classe do Mandrill
require_once('mandrill/src/Mandrill.php');

class Email
{
	/*---------------------------------------------------------------------------------------------------------------------------------
	 Construtor
	---------------------------------------------------------------------------------------------------------------------------------*/

	function __construct($key = 'ROFN9D0SVJaayNVdJ5slLA', $from = 'message.from_email@example.com', $from_name ='Actionaid')
	{
		//Chave de autenticação do Mandrill
		$this->key = $key;

		//Email de Origem
		$this->from = $from;

		//Nome de Origem
		$this->from_name = $from_name;
	}

	/*---------------------------------------------------------------------------------------------------------------------------------
	 Enviar e-mail apenas com texto
	---------------------------------------------------------------------------------------------------------------------------------*/

	public function enviarTexto($para, $assunto, $nome_destinatario, $texto)
	{
		try
		{
			$mandrill = new Mandrill($this->key);

			$mensagem = array(
				'text' => $texto,
				'subject' => $assunto,
				'from_email' => $this->from,
		        'from_name' => $this->from_name,
		        'to' => array(
		            array(
		                'email' => $para,
		                'name' => $nome_destinatario,
		                'type' => 'to'
		            )
		        ),
			);

			$async = false;
		    $ip_pool = 'Main Pool';

		    $result = $mandrill->messages->send($mensagem, $async, $ip_pool);

			return array('erro' => false);
		}
		catch(Mandrill_Error $e)
		{
			return array('erro' => true, 'mensagem' => 'Ocorreu um erro no Mandrill: ' . get_class($e) . ' - ' . $e->getMessage());
		}
	}

	/*---------------------------------------------------------------------------------------------------------------------------------
	 Enviar e-mails usando um template cadastrado no Mandrill
	---------------------------------------------------------------------------------------------------------------------------------*/

	public function enviarTemplate($para, $assunto, $nome_destinatario, $template, $tags)
	{
		try
		{
			$mandrill = new Mandrill($this->key);

			$mensagem = array(
				'subject' => $assunto,
				'from_email' => $this->from,
		        'from_name' => $this->from_name,
		        'to' => array(
		            array(
		                'email' => $para,
		                'name' => $nome_destinatario,
		                'type' => 'to'
		            )
		        ),
			);

			$async = false;
		    $ip_pool = 'Main Pool';

		    $result = $mandrill->messages->sendTemplate($template, $tags, $mensagem, $async, $ip_pool);

			return array('erro' => false);
		}
		catch(Mandrill_Error $e)
		{
			return array('erro' => true, 'mensagem' => 'Ocorreu um erro no Mandrill: ' . get_class($e) . ' - ' . $e->getMessage());
		}

	}

	/*---------------------------------------------------------------------------------------------------------------------------------
	 Enviar e-mails usando um arquivo HTML
	---------------------------------------------------------------------------------------------------------------------------------*/

	public function enviarHTML($para, $assunto, $nome_destinatario, $arquivo)
	{
		$template = file_get_contents($arquivo);

		if($template)
		{
			try
			{
				$mandrill = new Mandrill($this->key);

				$mensagem = array(
					'html' => $template,
					'subject' => $assunto,
					'from_email' => $this->from,
			        'from_name' => $this->from_name,
			        'to' => array(
			            array(
			                'email' => $para,
			                'name' => $nome_destinatario,
			                'type' => 'to'
			            )
			        ),
				);

				$async = false;
			    $ip_pool = 'Main Pool';

			    $result = $mandrill->messages->send($mensagem, $async, $ip_pool);

				return array('erro' => false);
			}
			catch(Mandrill_Error $e)
			{
				return array('erro' => true, 'mensagem' => 'Ocorreu um erro no Mandrill: ' . get_class($e) . ' - ' . $e->getMessage());
			}
		}
		else
		{
			return array('erro' => true, 'mensagem' => "Arquivo '$template' não encontrado");
		}
	}

}