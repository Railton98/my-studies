/**
 * Date utility functions for goal management
 * Handles calculations and formatting of goal deadlines
 */

import { differenceInDays, format, isToday, isTomorrow, parseISO } from "date-fns";

/**
 * Calculate the number of days remaining until the goal end date
 * @param endDate - ISO date string (YYYY-MM-DD)
 * @returns Number of days remaining (negative if overdue)
 */
export function getDaysRemaining(endDate: string): number {
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const end = parseISO(endDate);
  end.setHours(0, 0, 0, 0);

  return differenceInDays(end, today);
}

/**
 * Check if a goal is urgent (within 3 days of deadline)
 * @param endDate - ISO date string (YYYY-MM-DD)
 * @returns true if urgent (0-3 days remaining)
 */
export function isUrgent(endDate: string): boolean {
  const daysRemaining = getDaysRemaining(endDate);
  return daysRemaining >= 0 && daysRemaining <= 3;
}

/**
 * Format the days remaining as a human-readable string
 * @param endDate - ISO date string (YYYY-MM-DD)
 * @returns Formatted string like "3 days left", "Today", "Tomorrow", "Overdue"
 */
export function formatDaysRemaining(endDate: string): string {
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const end = parseISO(endDate);
  end.setHours(0, 0, 0, 0);

  if (isToday(end)) {
    return "Today";
  }

  if (isTomorrow(end)) {
    return "Tomorrow";
  }

  const daysRemaining = getDaysRemaining(endDate);

  if (daysRemaining < 0) {
    return "Overdue";
  }

  return `${daysRemaining} day${daysRemaining === 1 ? "" : "s"} left`;
}

/**
 * Format the end date for display
 * @param endDate - ISO date string (YYYY-MM-DD)
 * @returns Formatted date string like "Mar 15"
 */
export function formatEndDate(endDate: string): string {
  return format(parseISO(endDate), "MMM d");
}
