import pandas as pd
import mysql.connector

def insertar_datos_excel_a_mysql(ruta_excel, usuario_db, contrasena_db, host_db, nombre_db):
    # Leer el archivo Excel
    df = pd.read_excel(ruta_excel)

    # Conectar a la base de datos MySQL
    conexion = mysql.connector.connect(
        host=host_db,
        user=usuario_db,
        password=contrasena_db,
        database=nombre_db
    )
    cursor = conexion.cursor()

    try:
        for index, fila in df.iterrows():
            descripcion = fila['descripcion']
            pCFECategorias_id = fila['pCFECategorias_id']
            codigo_sat = fila['codigo_sat']

            # Procesar las columnas relacionadas con -4, -6, -8
            for sufijo in ['4', '6', '8']:
                print(int(sufijo) * 1000)
                p_mo = fila[f'p_mo-{sufijo}']
                p_refaccion = fila[f'p_refaccion-{sufijo}']
                p_total = fila[f'p_total-{sufijo}']

                # Insertar en la tabla pcfeconceptos
                consulta_conceptos = """
                INSERT INTO pcfeconceptos (descripcion, p_mo, p_refaccion, p_total, pCFECategorias_id, codigo_sat,num,pCFETipos_id,tiempo,codigo_unidad,unidad_text,id_anio_correspondiente)
                VALUES (%s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s)
                """
                cursor.execute(consulta_conceptos, (descripcion, p_mo, p_refaccion, p_total, pCFECategorias_id, codigo_sat,'FC',int(sufijo) * 1000,'1.0','H87','Pieza','3'))


        # Confirmar los cambios
        conexion.commit()
        print("Datos insertados correctamente.")

    except Exception as e:
        print(f"Ocurrió un error: {e}")
        conexion.rollback()

    finally:
        # Cerrar la conexión
        cursor.close()
        conexion.close()

# Configuración
ruta_excel = "C:/Users/jchug/Documents/sistema de frenos.xlsx"
usuario_db = "root"
contrasena_db = ""
host_db = "127.0.0.1"
nombre_db = "cfbtac"

insertar_datos_excel_a_mysql(ruta_excel, usuario_db, contrasena_db, host_db, nombre_db)
