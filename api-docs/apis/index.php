<?php

$data = '{
			  "apiVersion": "1.0.0",
			  "basePath": "http://localhost/~karvin/ci3.0/index.php/ordermanage",
			  "apis": [

					{
			      "path": "/createUser",
			      "operations": [
			        {
			          "method": "POST",
			          "summary":"this function is used to  create an user",
			          "nickname": "createUser",
			          "parameters": [
			            {
			              "name": "useremail",
			              "description": "email id of the user",
			              "required": true,
			              "type": "varchar",
			              "paramType": "form"
			            },{
			              "name": "username",
			              "description": "Name of the user",
			              "required": true,
			              "type": "varchar",
			              "paramType": "form"
			            }
			           ]
			        }
			      ]
			    },

			    {
			      "path": "/createOrder",
			      "operations": [
			        {
			          "method": "POST",
			          "summary":" this function is used to create an order",
			          "nickname": "createOrder",
			          "parameters": [
			            {
			              "name": "userid",
			              "description": "User id of the user",
			              "required": true,
			              "type": "varchar",
			              "paramType": "form"
			            },{
			              "name": "item_info",
			              "description": "it will be in the form of json, please read the readme.txt file for more details",
			              "required": true,
			              "type": "varchar",
			              "paramType": "form"
			            }
			           ]
			        }
			      ]
			    },

					{
			      "path": "/getOrder",
			      "operations": [
			        {
			          "method": "POST",
			          "summary":"Function is to fetch all the order according to user_id or order_id",
			          "nickname": "getOrder",
			          "parameters": [
			            {
			              "name": "userid",
			              "description": "User id of the user",
			              "required": false,
			              "type": "int",
			              "paramType": "form"
			            },{
			              "name": "orderid",
			              "description": "it will be in the form of JSON",
			              "required": false,
			              "type": "int",
			              "paramType": "form"
			            }
			           ]
			        }
			      ]
			    },{
			      "path": "/getTodaysOrder",
			      "operations": [
			        {
			          "method": "POST",
			          "summary":"This function is userd to get orders of today only.",
			          "nickname": "getTodaysOrder",
			          "parameters": [

			           ]
			        }
			      ]
			    },
					{
			      "path": "/updateOrder",
			      "operations": [
			        {
			          "method": "POST",
			          "summary":"function is used to update the order, order_cancel, order_payment_recieved , order_items_update etc.",
			          "nickname": "getOrder",
			          "parameters": [
									{
			              "name": "order_id",
			              "description": "Order id",
			              "required": true,
			              "type": "int",
			              "paramType": "form"
			            },
			            {
			              "name": "is_cancel",
			              "description": "if order is cancelled then value shoould be 1, otherwise it will be blank.",
			              "required": false,
			              "type": "int",
			              "paramType": "form"
			            },{
			              "name": "is_payment",
			              "description": "if payment is received then its value should be 1, other it will be blank",
			              "required": false,
			              "type": "int",
			              "paramType": "form"
			            },{
			              "name": "item_info",
			              "description": "it will be in the form of json, please read the readme.txt file for more details.",
			              "required": false,
			              "type": "varchar",
			              "paramType": "form"
			            }
			           ]
			        }
			      ]
			    }

				 ]
				}';

		echo $data;
