import os
from datetime import datetime
import pytz

# Define the Stockholm timezone
STOCKHOLM_TIMEZONE = pytz.timezone('Europe/Stockholm')

# Set dry-run mode (True = simulate, False = apply changes)
DRY_RUN = False

def parse_date_string(date_string):
    """
    Parse the date string from a file's first line.
    Supports multiple formats and defaults to midnight if no time is provided.
    """
    formats = [
        "%Y-%m-%d %H:%M",       # Format: 2024-11-15 10:35
        "%Y-%m-%d",             # Format: 2024-11-15 (defaults to 00:00)
        "%d %b %Y",             # Format: 20 May 2016 (defaults to 00:00)
        "%d %b %Y, %H:%M",      # Format: 20 Mar 2019, 16:46
        "%d %b %Y %H:%M",       # Format: 11 Mar 2018 13:28
        "%b %d %Y %H:%M",       # Format: May 3 2016 23:36
        "%d %B %Y %H:%M",       # Format: 31 July 2016 14:57
        "%b %d %Y",             # Format: May 3 2016 (defaults to 00:00)
        "%m/%d/%Y %H:%M",       # Format: 01/25/2017 21:18
        "%d %B %Y, %H:%M",      # Format: 6 June 2019, 02:57
        "%d %b %Y, %H:%M:%S",   # Format: 2 Jul 2017, 02:47:55
        "%B %d %Y %H:%M",       # Format: February 8 2016 20:16
        "%Y-%m-%d %H:%M",       # Format: 2024-11-15 10:35
        "%Y-%m-%d",             # Format: 2024-11-15 (defaults to 00:00)
        "%d %b %Y",             # Format: 20 May 2016 (defaults to 00:00)
        "%d %B %Y",             # Format: 26 April 2016 (defaults to 00:00)
        "%d %b %Y, %H:%M",      # Format: 20 Mar 2019, 16:46
        "%d %b %Y %H:%M",       # Format: 11 Mar 2018 13:28
        "%b %d %Y %H:%M",       # Format: May 3 2016 23:36
        "%b %d %Y, %H:%M",      # Format: Jan 12 2020, 16:12
        "%d %B %Y, %H:%M",      # Format: 6 June 2019, 02:57
        "%d %b %Y, %H:%M:%S",   # Format: 2 Jul 2017, 02:47:55
        "%m/%d/%Y %H:%M",       # Format: 01/25/2017 21:18
        "%Y-%m-%d %H:%M:%S",    # Format: 2016-01-03 20:17:00
        "%B %d %Y %H:%M",       # Format: February 8 2016 20:16
    ]
    
    # Normalize 'st', 'nd', 'rd', and 'th' (e.g., '3rd' -> '3')
    cleaned_date = date_string.replace("st", "").replace("nd", "").replace("rd", "").replace("th", "")
    
    for fmt in formats:
        try:
            return datetime.strptime(cleaned_date, fmt)
        except ValueError:
            continue
    raise ValueError(f"Unrecognized date format: {date_string}")

def convert_to_utc_iso_date(file_path):
    try:
        with open(file_path, 'r', encoding='utf-8') as file:
            lines = file.readlines()

            # Skip files without content
            if not lines:
                return

            # Parse the first line as datetime
            first_line = lines[0].strip()
            try:
                # Attempt to parse the date
                naive_dt = parse_date_string(first_line)
                # Localize to Stockholm timezone
                stockholm_dt = STOCKHOLM_TIMEZONE.localize(naive_dt)
                # Format with ISO format including timezone offset
                iso_date_with_offset = stockholm_dt.strftime("%Y-%m-%dT%H:%M:%S%z")
                # Add colon to timezone offset for ISO-8601 compliance
                iso_date_with_offset = (
                    iso_date_with_offset[:-2] + ":" + iso_date_with_offset[-2:]
                )

                # Dry-run or actual update
                if DRY_RUN:
                    print(f"{file_path}: {first_line} --> {iso_date_with_offset}")
                else:
                    # Replace the first line with the ISO date
                    lines[0] = iso_date_with_offset + "\n"
                    with open(file_path, 'w', encoding='utf-8') as writable_file:
                        writable_file.writelines(lines)
                    print(f"Updated: {file_path}")
            except ValueError as e:
                print(f"Skipped (invalid date): {file_path} ({e})")
    except Exception as e:
        print(f"Error processing {file_path}: {e}")


def process_folder(folder_path):
    for root, _, files in os.walk(folder_path):
        for file in files:
            if file.endswith(('.txt', '.md')):
                file_path = os.path.join(root, file)
                convert_to_utc_iso_date(file_path)

# Path to your main folder
folder_path = "./posts/" #/path/to/your/blog/folder"
process_folder(folder_path)

